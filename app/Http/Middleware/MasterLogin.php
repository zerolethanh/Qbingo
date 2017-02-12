<?php

namespace App\Http\Middleware;

use App\Master;
use Closure;
use Illuminate\Support\Facades\Auth;

class MasterLogin
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
        if (Auth::guard('master')->check()) {
            self::saveSessionMasterAndShareView();
            return $next($request);
        }
        return redirect('/master');

    }

    public static function saveSessionMasterAndShareView()
    {
        $master = Master::user();
        session(compact(Master::SESSION_MASTER_KEY));
        view()->share(compact(Master::SESSION_MASTER_KEY));
    }
}
