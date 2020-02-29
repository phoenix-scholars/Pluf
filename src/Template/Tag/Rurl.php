<?php
namespace Pluf\Template\Tag;


/**
 * Assign the url to a template variable.
 */
class Pluf_Template_Tag_Rurl extends \Pluf\Template\Tag
{

    function start ($var, $view, $params = array(), $get_params = array())
    {
        $this->context->set($var, 
                Pluf_HTTP_URL_urlForView($view, $params, $get_params));
    }
}