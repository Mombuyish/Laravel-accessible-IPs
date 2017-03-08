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

        $whilelists = ! $in($request->ip(), config('access-ip.white'));

        $blacklists = $in($request->ip(), config('access-ip.black'));

        $empty_config = empty(config('access-ip.white')) && empty(config('access-ip.black'));

        if ($empty_config) {
            return $next($request);
        }

        if ($whilelists OR $blacklists) {
            abort(403, "Only Accessible for developers from Internal.");
        }

        return $next($request);
    }
}
