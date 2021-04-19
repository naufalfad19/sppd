<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Sentinel;

class SentinelAuth
{
    public function handle($request, Closure $next)
    {
      if (Sentinel::guest()) {
          if ($request->ajax() || $request->wantsJson()) {
              return response('Unauthorized.', 403);
          } else {
              return redirect()->guest('login');
          }
      }

      return $next($request);
    }
}
