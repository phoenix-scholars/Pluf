<?php
function SaaSDM_Shortcuts_GetLinkOr404($id) {
	$item = new SaaSDM_Link ( $id );
	if (( int ) $id > 0 && $item->id == $id) {
		return $item;
	}
	throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM link not found (link id:" . $id . ")" );
}
function SaaSDM_Shortcuts_GetLinkBySecureIdOr404($secure_id) {
	$item = SaaSDM_Link::getLinkBySecureId ( $secure_id );
	if ($item == null || $item->id <= 0) {
		throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM link not found (link id:" . $secure_id . ")" );
	}
	return $item;
}
function SaaSDM_Shortcuts_GetAssetOr404($id) {
	$item = new SaaSDM_Asset ( $id );
	if (( int ) $id > 0 && $item->id == $id) {
		return $item;
	}
	throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM asset not found (asset id:" . $id . ")" );
}
function SaaSDM_Shortcuts_GetPlanTemplateOr404($id) {
	$item = new SaaSDM_PlanTemplate ( $id );
	if (( int ) $id > 0 && $item->id == $id) {
		return $item;
	}
	throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM plan template not found (plan template id:" . $id . ")" );
}
function SaaSDM_Shortcuts_GetPlanOr404($id) {
	$item = new SaaSDM_Plan ( $id );
	if (( int ) $id > 0 && $item->id == $id) {
		return $item;
	}
	throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM plan not found (plan id:" . $id . ")" );
}
function SaaSDM_Shortcuts_GetAccountOr404($id) {
	$item = new SaaSDM_Account ( $id );
	if (( int ) $id > 0 && $item->id == $id) {
		return $item;
	}
	throw new SaaSDM_Exception_ObjectNotFound ( "SaaSDM account not found (plan id:" . $id . ")" );
}