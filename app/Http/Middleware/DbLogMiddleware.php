<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class DbLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::enableQueryLog();
        $response = $next($request);
        $sqls = DB::getQueryLog();
        $sqls_string = "";
        foreach ($sqls as $sql) {
            $bindings = $sql['bindings'];
//            $time = $sql->time;
            $sql = $sql['query'];
            $sql = $this->applyBindings($sql, $bindings);
            $sqls_string .= $sql . '; ' . PHP_EOL;

        }
        if (isset($sqls_string)) {

        }
        DB::disableQueryLog();
    }
    private function applyBindings($sql, array $bindings)
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
