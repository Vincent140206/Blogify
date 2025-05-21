<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Jika sudah login, redirect ke dashboard
            return redirect('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return $next($request);
    }
}
