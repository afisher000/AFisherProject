<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IPWhitelist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = ['127.0.0.1', '76.94.217.208', '128.97.102.187'];
        $clientIp = $request->ip();

        if (in_array($clientIp, $allowedIps)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }

}
