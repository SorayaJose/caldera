<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $permiso  El nivel de permiso requerido (bajo, medio, total)
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permiso = 'bajo')
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }

        /** @var User $user */
        $user = auth()->user();

        if ((int) ($user->rol ?? 0) === User::ROL_ADMIN) {
            return $next($request);
        }

        // Verificar si el usuario tiene el permiso requerido
        if (!$user->tienePermiso($permiso)) {
            abort(403, 'No tienes permisos suficientes para acceder a esta página');
        }

        return $next($request);
    }
}
