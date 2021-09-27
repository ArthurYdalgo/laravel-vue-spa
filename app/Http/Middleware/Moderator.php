<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Moderator
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
        $allowed_roles = ['moderator', 'administrator', 'master'];
        
        if($request->user('api')->hasRole($allowed_roles)){
            return $next($request);
        }

        return response()->json(['error_details'=>'middleware_moderator_denied'],403);

    }
}
