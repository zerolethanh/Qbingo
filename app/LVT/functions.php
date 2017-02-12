<?php
/**
 * User: ZE
 * Date: 2017/01/30
 * Time: 20:34
 */

if (!function_exists('updateView')) {
    function updateView($view, $data = null, $UPDATE_VIEW_HTML_ID = null)
    {
        $UPDATE_VIEW_HTML_ID = $UPDATE_VIEW_HTML_ID ?: last(explode('.', $view));

        if (!view()->exists($view)) {
            throw  new ErrorException("$view not be found");
        }

        //render view string
        ${$UPDATE_VIEW_HTML_ID} = view($view, compact('data'))->render();
        $date = date('c');
        return get_defined_vars();
//            [
//            'UPDATE_VIEW_HTML_ID' => $html_id,
//            "$html_id" => $viewRenderString,
//            'time' => time(),
//            'vars' => get_defined_vars()
//        ];
//        return compact("$html_id", "UPDATE_VIEW_HTML_ID", 'data');
    }
}