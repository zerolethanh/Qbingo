<?php
/**
 * User: ZE
 * Date: 2017/01/30
 * Time: 20:34
 */

if (!function_exists('updateView')) {
    function updateView($view, $data, $html_id = null)
    {
        if (!$html_id) {
            $html_id = last(explode('.', $view));
        }
        if (!view()->exists($view)) {
            throw  new ErrorException("$view not be found");
        }

        //render view string
        ${$html_id} = view($view, $data)->render();
        $UPDATE_VIEW_HTML_ID = $html_id;
        return compact("$html_id", "UPDATE_VIEW_HTML_ID");
    }
}