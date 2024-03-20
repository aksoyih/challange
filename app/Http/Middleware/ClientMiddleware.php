<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientToken = $request->header('Client-Token');

        if(!$clientToken) {
            return response()->json(['error' => 'Failed to authenticate, Client-Token is required'], 401);
        }

        $device = Device::where('client_token', $clientToken)->first();
        if(!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $request->merge(['device' => $device]);
        return $next($request);
    }
}
