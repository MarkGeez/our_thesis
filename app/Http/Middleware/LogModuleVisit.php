<?php

namespace App\Http\Middleware;

use App\Services\ActiveLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogModuleVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('get') && !$request->ajax() && !$request->expectsJson()) {
            $user = $request->user();

            if ($user && in_array($user->role, ['admin', 'subadmin'], true)) {
                $module = $this->resolveModuleName($request);
                $roleLabel = $user->role === 'subadmin' ? 'Subadmin' : 'Admin';

                ActiveLogger::log(
                    $module,
                    'visited',
                    null,
                    sprintf('%s visited %s module', $roleLabel, $module)
                );
            }
        }

        return $next($request);
    }

    private function resolveModuleName(Request $request): string
    {
        $routeName = $request->route()?->getName();

        if (is_string($routeName) && $routeName !== '') {
            $normalized = preg_replace('/^(admin|subadmin)\./', '', $routeName);
            $normalized = preg_replace('/[._-]+/', ' ', (string) $normalized);
            $normalized = trim((string) $normalized);

            if ($normalized !== '') {
                return Str::headline($normalized);
            }
        }

        $segments = $request->segments();
        $moduleSegment = $segments[1] ?? null;

        if (is_string($moduleSegment) && $moduleSegment !== '') {
            return Str::headline($moduleSegment);
        }

        return 'Module';
    }
}
