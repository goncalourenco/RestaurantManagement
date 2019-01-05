<?php

namespace App\Http\Middleware;

use Closure;

class isWaiterOrCook
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
        if ($request->user() && ($request->user()->type == 'cook'|| $request->user()->type == 'waiter')) {
            return $next($request);
        }

        return Response::json([
            'unauthorized' => 'Only cooks or waiters are alowed!'
        ], 401);
    }
}
