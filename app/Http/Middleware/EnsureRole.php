<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pemakaian: ->middleware(EnsureRole::class . ':admin,petugas')
 * Peran khusus "civitas" = mahasiswa, dosen, tendik.
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        abort_unless($user, 401);

        $allowed = collect($roles)
            ->flatMap(fn ($r) => $r === 'civitas' ? ['mahasiswa', 'dosen', 'tendik'] : [$r])
            ->all();

        abort_unless(in_array($user->peran, $allowed, true), 403, 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
