<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTimeZone;
class DetectUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
       public function handle(Request $request, Closure $next)
    {
        // Lấy từ cookie hoặc session
        $tz = $request->cookie('user_tz') ?? $request->session()->get('user_tz');

        // Nếu hợp lệ thì set
        if ($tz && in_array($tz, DateTimeZone::listIdentifiers())) {
            config(['app.timezone' => $tz]);
            date_default_timezone_set($tz);
        }

        return $next($request);
    }
    


    }
