<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Accès réservé à l\'administration.']);
        }

        return $next($request);
    }
}
