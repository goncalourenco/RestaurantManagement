<?php

namespace App\Http\Middleware;

use Closure;

class isManager
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
        if ($request->user() && $request->user()->type == 'manager') {
            return $next($request);
        }

        return Response::json([
            'unauthorized' => 'Only cooks are alowed!'
        ], 401);
    }
}
