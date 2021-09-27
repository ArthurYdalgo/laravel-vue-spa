<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowed_roles = ['administrator', 'master'];
        
        if($request->user('api')->hasRole($allowed_roles)){
            return $next($request);
        }

        return response()->json(['error_details'=>'middleware_administrator_denied'],403);
    }
}
