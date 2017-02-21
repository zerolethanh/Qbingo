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
if (!function_exists('dbStartLog')) {
    function dbStartLog()
    {
        app('db')->enableQueryLog();
    }
}
if (!function_exists('dbEndLog')) {
    function dbEndLog(Closure $closure = null)
    {
        $sqls = app('db')->getQueryLog();
        $sqls_string = "";

        foreach ($sqls as $sql) {
            $bindings = $sql['bindings'];
//            $time = $sql->time;
            $sql = $sql['query'];
            $sql = dbBindings($sql, $bindings);
            $sqls_string .= $sql . '; ' . PHP_EOL;
        }

        if (isset($sqls_string)) {
            app('log')->info($sqls_string);
            if (!is_null($closure)) {
                $closure($sqls_string);
            }
            return $sqls_string;
        }
        app('db')->disableQueryLog();
    }

    function dbBindings($sql, array $bindings)
    {
        if (empty($bindings)) {
            return $sql;
        }

        $placeholder = preg_quote('?', '/');
        foreach ($bindings as $binding) {
            $binding = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/' . $placeholder . '/', $binding, $sql, 1);
        }

        return $sql;
    }
}