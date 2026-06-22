<?php

namespace App\Http\Middleware;

use App\Models\ClienteEntrenador;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrainerOrClientMiddleware
{
    /**
     * Allow access when the authenticated user is the requested client or their active trainer.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $routeParameter = 'id'): Response
    {
        $user = Auth::user();
        $routeValue = $request->route($routeParameter);

        $isOwner = $user && $routeValue !== null && (int) $routeValue === (int) $user->id;
        $isActiveTrainer = $user
            && $routeValue !== null
            && $user->rol === 'entrenador'
            && ClienteEntrenador::existeRelacionActiva($user->id, (int) $routeValue);

        if (! $isOwner && ! $isActiveTrainer) {
            abort(403);
        }

        return $next($request);
    }
}
