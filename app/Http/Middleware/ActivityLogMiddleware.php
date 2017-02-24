<?php

namespace App\Http\Middleware;

use App\Activity;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    static $BINGO_URL = 'bingo*';

    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
//        info(['is' => $request->is(static::$BINGO_URL)]);
        if ($request->is(static::$BINGO_URL)) {
            Activity::create([
                'happy_id' => $request->user()->id,
                'url' => $request->url(),
                'last' => Carbon::now()
            ]);
        }
    }
}
