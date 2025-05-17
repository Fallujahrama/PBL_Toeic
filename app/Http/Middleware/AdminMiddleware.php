<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika user adalah admin (level_id 1 atau 2)
        if (Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}