<?php

namespace Mombuyish\AccessibleIP\Middleware;

use Closure;

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
        $in = function($ip, $lists) {
            return in_array($ip, $lists);
        };

        /**
         * setTrustedProxies
         */
        $request->setTrustedProxies(config('access-ip.allowed'));

        $whitelists = $in($request->ip(), config('access-ip.allowed'));

        if (! $whitelists) {
            abort(403, "Only Accessible for Allow lists.");
        }

        return $next($request);
    }
}
