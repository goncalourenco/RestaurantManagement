<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Response;

use Closure;

class isWaiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->type == 'waiter') {
            return $next($request);
        }

        return Response::json([
            'unauthorized' => 'Only waiters are alowed!'
        ], 401);
    }
}
