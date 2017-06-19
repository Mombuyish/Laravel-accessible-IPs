<?php

namespace Mombuyish\AccessibleIP\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\IpUtils;

class AccessibleIPAddress
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
        $proxies = config('access-ip.proxies');

        if (! empty($proxies)) {
            $request->setTrustedProxies($proxies);
        }

        $ips = array_merge(['127.0.0.1'], config('access-ip.allowed'));

        if (! IpUtils::checkIp($request->ip(), $ips)) {
            abort(403, "Only Accessible for Allow lists.");
        }

        return $next($request);
    }
}
