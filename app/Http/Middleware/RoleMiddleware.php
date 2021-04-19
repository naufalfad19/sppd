<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Sentinel;

class RoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!Sentinel::getUser()->inrole(1)){
          return redirect()->route('home.dashboard');
        }
        return $next($request);
    }
}
