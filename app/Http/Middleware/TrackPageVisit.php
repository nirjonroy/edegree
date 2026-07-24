<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    private const VISITOR_COOKIE = 'frontend_visitor_id';

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            [$visitorId, $needsCookie] = $this->visitorId($request);
            $path = '/'.ltrim($request->path(), '/');

            PageVisit::create([
                'user_id' => $request->user()?->id,
                'visitor_id' => $visitorId,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'ip_address' => $request->ip(),
                'mac_address' => null,
                'is_frontend' => true,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $path,
                'route_name' => $request->route()?->getName(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),
                'visited_at' => now(),
            ]);

            if ($needsCookie) {
                $response->headers->setCookie(Cookie::make(
                    self::VISITOR_COOKIE,
                    $visitorId,
                    60 * 24 * 365,
                    '/',
                    null,
                    $request->isSecure(),
                    true,
                    false,
                    'Lax'
                ));
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $request->expectsJson() || $response instanceof JsonResponse) {
            return false;
        }

        if ($response->getStatusCode() !== 200 || ! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return false;
        }

        if ($request->is([
            '_debugbar*',
            'telescope*',
            'horizon*',
            'admin*',
            'adminlte*',
            'api*',
            'seo-admin*',
            'seo-media*',
            'storage*',
            'uploads*',
            'build*',
            'css*',
            'js*',
            'images*',
            'img*',
            'fonts*',
            'vendor*',
            'favicon.ico',
            'robots.txt',
            'sitemap*',
            '.well-known*',
        ])) {
            return false;
        }

        $routeName = (string) $request->route()?->getName();

        return str_starts_with($routeName, 'frontend.')
            || $request->is('/')
            || $request->is('frontend/*');
    }

    private function visitorId(Request $request): array
    {
        if ($request->user()) {
            return ['user:'.$request->user()->id, false];
        }

        $visitorId = $request->cookie(self::VISITOR_COOKIE);

        if ($visitorId) {
            return [$visitorId, false];
        }

        return [(string) Str::uuid(), true];
    }
}
