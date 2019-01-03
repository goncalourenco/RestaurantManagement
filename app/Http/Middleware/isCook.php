<?php

namespace App\Http\Middleware;

use Closure;

class isCook
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
        if ($request->user() && $request->user()->type == 'cook') {
            return $next($request);
        }

        return Response::json([
            'unauthorized' => 'Only cooks are alowed!'
        ], 401);
    }
}
