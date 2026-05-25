<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user && $user->hasAnyRole($roles)) {
            return $next($request);
        }

        return redirect()
            ->route('dashboard')
            ->with('warning', 'Akun Anda tidak memiliki akses ke halaman tersebut.');
    }
}
