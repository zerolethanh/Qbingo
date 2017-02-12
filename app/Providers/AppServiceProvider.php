<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->listenDB();
        $this->logRequest();
        $this->viewShareData();
    }

    public function viewShareData()
    {
        view()->share('UPDATE_VIEW_HTML_ID', 'UPDATE_VIEW_HTML_ID');
    }

    function listenDB()
    {
        DB::listen(function ($query) {
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            Log::debug(compact('sql', 'bindings', 'time'), [__CLASS__ . '@' . __FUNCTION__]);
        });
    }

    function logRequest()
    {
        $method = request()->method();
        $url = request()->url();
        $request_all = request()->all();
        Log::debug(get_defined_vars(), [__CLASS__ . '@' . __FUNCTION__]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
