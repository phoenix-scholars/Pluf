<?php
return array(
        // ************************************************************* Assets
        array( // Create
                'regex' => '#^/asset/new$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'create',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Find
                'regex' => '#^/asset/find$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'find',
                'http-method' => 'GET'
        ),
        array( // Get information
                'regex' => '#^/asset/(?P<id>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'get',
                'http-method' => 'GET'
        ),
        array( // Delete
                'regex' => '#^/asset/(?P<id>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'delete',
                'http-method' => 'DELETE',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Update
                'regex' => '#^/asset/(?P<id>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'update',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Find childs (if asset is folder)
                'regex' => '#^/asset/(?P<id>\d+)/find$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'findchild',
                'http-method' => 'GET'
        ),
        // ************************************************************* Tags on Assets
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/tag/find$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'tags',
                'http-method' => 'GET'
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/tag/new$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'addTag',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/tag/(?P<tagId>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'addTag',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/tag/(?P<tagId>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'removeTag',
                'http-method' => 'DELETE',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Categories of Assets
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/category/find$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'categories',
                'http-method' => 'GET'
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/category/new$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'addCategory',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/category/(?P<categoryId>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'addCategory',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/asset/(?P<assetId>\d+)/category/(?P<categoryId>\d+)$#',
                'model' => 'SDP_Views_Asset',
                'method' => 'removeCategory',
                'http-method' => 'DELETE',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Category
        array( // Find
                'regex' => '#^/category/find$#',
                'model' => 'Pluf_Views',
                'method' => 'findObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_Category',
                        'listFilters' => array(
                                'id',
                                'name',
                                'parent'
                        ),
                        'searchFields' => array(
                                'name',
                                'description'
                        ),
                        'sortFields' => array(
                                'id',
                                'name',
                                'parent',
                                'creation_date',
                                'modif_dtime'
                        )
                )
        ),
        array( // Create
                'regex' => '#^/category/new$#',
                'model' => 'Pluf_Views',
                'method' => 'createObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_Category'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Get info
                'regex' => '#^/category/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'getObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_Category'
                )
        ),
        array( // Delete
                'regex' => '#^/category/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'deleteObject',
                'http-method' => 'DELETE',
                'params' => array(
                        'model' => 'SDP_Category',
                        'permanently' => true
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Update
                'regex' => '#^/category/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'updateObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_Category'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Assets in Category
        array(
                'regex' => '#^/category/(?P<categoryId>\d+)/asset/find$#',
                'model' => 'SDP_Views_Category',
                'method' => 'assets',
                'http-method' => 'GET'
        ),
        array(
                'regex' => '#^/category/(?P<categoryId>\d+)/asset/new$#',
                'model' => 'SDP_Views_Category',
                'method' => 'addAsset',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/category/(?P<categoryId>\d+)/asset/(?P<assetId>\d+)$#',
                'model' => 'SDP_Views_Category',
                'method' => 'addAsset',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/category/(?P<categoryId>\d+)/asset/(?P<assetId>\d+)$#',
                'model' => 'SDP_Views_Category',
                'method' => 'removeAsset',
                'http-method' => 'DELETE',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Tag
        array( // Find
                'regex' => '#^/tag/find$#',
                'model' => 'Pluf_Views',
                'method' => 'findObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_Tag',
                        'listFilters' => array(
                                'id',
                                'name'
                        ),
                        'searchFields' => array(
                                'name',
                                'description'
                        ),
                        'sortFields' => array(
                                'id',
                                'name',
                                'creation_date',
                                'modif_dtime'
                        )
                )
        ),
        array( // Create
                'regex' => '#^/tag/new$#',
                'model' => 'Pluf_Views',
                'method' => 'createObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_Tag'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Get info
                'regex' => '#^/tag/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'getObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_Tag'
                )
        ),
        array( // Get info (by name)
                'regex' => '#^/tag/(?P<name>[^/]+)$#',
                'model' => 'SDP_Views_Tag',
                'method' => 'getByName',
                'http-method' => 'GET'
        ),
        array( // Delete
                'regex' => '#^/tag/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'deleteObject',
                'http-method' => 'DELETE',
                'params' => array(
                        'model' => 'SDP_Tag',
                        'permanently' => true
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Update
                'regex' => '#^/tag/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'updateObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_Tag'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Assets with Tag
        array(
                'regex' => '#^/tag/(?P<tagId>\d+)/asset/find$#',
                'model' => 'SDP_Views_Tag',
                'method' => 'assets',
                'http-method' => 'GET'
        ),
        array(
                'regex' => '#^/tag/(?P<tagId>\d+)/asset/new$#',
                'model' => 'SDP_Views_Tag',
                'method' => 'addAsset',
                'http-method' => 'POST',
                'precond' => array(
                        'SaaS_Precondition::tenantOwner'
                )
        ),
        array(
                'regex' => '#^/tag/(?P<tagId>\d+)/asset/(?P<assetId>\d+)$#',
                'model' => 'SDP_Views_Tag',
                'method' => 'addAsset',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/tag/(?P<tagId>\d+)/asset/(?P<assetId>\d+)$#',
                'model' => 'SDP_Views_Tag',
                'method' => 'removeAsset',
                'http-method' => 'DELETE',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* Link
        array( // Link urls
                'regex' => '#^/asset/(?P<asset_id>\d+)/link$#',
                'model' => 'SDP_Views_Link',
                'method' => 'create',
                'http-method' => 'GET',
                'precond' => array(
                        'Pluf_Precondition::loginRequired'
                )
        ),
        array( // Link urls
                'regex' => '#^/link/(?P<id>\d+)$#',
                'model' => 'SDP_Views_Link',
                'method' => 'get',
                'http-method' => 'GET',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Link urls
                'regex' => '#^/link/find$#',
                'model' => 'SDP_Views_Link',
                'method' => 'find',
                'http-method' => 'GET',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* download asset
        array( // Download urls
                'regex' => '#^/download/(?P<secure_link>.+)$#',
                'model' => 'SDP_Views_Link',
                'method' => 'download',
                'http-method' => 'GET'
        ),
        // ************************************************************* Payments
        array( // pay to get secure link for an asset which has price
                'regex' => '#^/link/(?P<linkId>\d+)/pay$#',
                'model' => 'SDP_Views_Link',
                'method' => 'payment',
                'http-method' => 'POST',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array( // Activate secure link that has been activated
                'regex' => '#^/link/(?P<linkId>\d+)/activate$#',
                'model' => 'SaaSDM_Views_Link',
                'method' => 'activate',
                'http-method' => 'GET',
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        // ************************************************************* AssetRelation
        array(
                'regex' => '#^/assetrelation/find$#',
                'model' => 'Pluf_Views',
                'method' => 'findObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_AssetRelation',
                        'listFilters' => array(
                                'id',
                                'type',
                                'start',
                                'end'
                        ),
                        'listDisplay' => array(
                                'type' => 'type',
                                'description' => 'description'
                        ),
                        '$searchFields' => array(
                                'type',
                                'start',
                                'end',
                                'description'
                        ),
                        'sortFields' => array(
                                'id',
                                'type',
                                'start',
                                'end',
                                'creation_date',
                                'modif_dtime'
                        )
                )
        ),
        array(
                'regex' => '#^/assetrelation/new$#',
                'model' => 'Pluf_Views',
                'method' => 'createObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_AssetRelation'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'getObject',
                'http-method' => 'GET',
                'params' => array(
                        'model' => 'SDP_AssetRelation'
                )
        ),
        array(
                'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'deleteObject',
                'http-method' => 'DELETE',
                'params' => array(
                        'model' => 'SDP_AssetRelation',
                        'permanently' => true
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        ),
        array(
                'regex' => '#^/assetrelation/(?P<modelId>\d+)$#',
                'model' => 'Pluf_Views',
                'method' => 'updateObject',
                'http-method' => 'POST',
                'params' => array(
                        'model' => 'SDP_AssetRelation'
                ),
                'precond' => array(
                        'Pluf_Precondition::memberRequired'
                )
        )
);