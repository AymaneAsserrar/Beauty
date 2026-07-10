<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Autorise l'accès uniquement aux utilisateurs possédant l'un des rôles requis.
     *
     * Usage dans les routes : ->middleware('role:admin')
     *                         ->middleware('role:admin,prestataire')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Non connecté -> on laisse le middleware 'auth' gérer la redirection login.
        if (! $user) {
            abort(403);
        }

        // Le rôle de l'utilisateur ne fait pas partie des rôles autorisés.
        if (! in_array($user->role, $roles, true)) {
            abort(403, "Accès non autorisé à cette section.");
        }

        return $next($request);
    }
}
