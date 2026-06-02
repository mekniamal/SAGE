<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login.form')
                ->with('error', 'Connectez-vous avec un compte administrateur.');
        }

        if (! auth()->user()->isAdmin()) {
            return redirect()->route('shop')
                ->with('error', 'Accès refusé. Ce compte n\'a pas les droits administrateur.');
        }

        return $next($request);
    }
}
