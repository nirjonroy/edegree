<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            PageVisit::create([
                'user_id' => $request->user()?->id,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'ip_address' => $request->ip(),
                'mac_address' => null,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => '/'.$request->path(),
                'route_name' => $request->route()?->getName(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),
                'visited_at' => now(),
            ]);
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET') || $request->expectsJson()) {
            return false;
        }

        return ! $request->is([
            '_debugbar*',
            'telescope*',
            'horizon*',
            'storage*',
            'uploads*',
            'adminlte*',
            'css*',
            'js*',
            'images*',
            'favicon.ico',
        ]);
    }
}
