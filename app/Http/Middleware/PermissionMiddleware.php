<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Route;
use Request;
use Session;
use Illuminate\Support\Facades\Log;


class PermissionMiddleware
{

    public function handle($request, Closure $next, $api="")
    {
        $routeName = $request->route()->getName();
        $uri = $request->route()->uri();

        if (empty($routeName) || Sentinel::hasAccess($routeName)) {
            Log::notice('User '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name.' Mengakses '.$uri);
            return $next($request);
        }else{
            Log::warning('User '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name.' Mengakses '.$uri);
            toast()->warning('Anda Tidak Memiliki Izin Kesini.', 'Warning');
            toast()->warning('Silakan Hubungi Admin Untuk Meminta Izin.', 'Warning');
            return redirect()->back();
        }

        if (!empty($api))
        {
            return response()->json(['message' => 'you_dont_have_permission_to_use_this_route'], 403);
        }else{
            toast()->warning('Anda Tidak Memiliki Izin Kesini.', 'Warning');
            toast()->warning('Silakan Hubungi Admin Untuk Meminta Izin.', 'Warning');
            return redirect()->back();
        }
    }
}
