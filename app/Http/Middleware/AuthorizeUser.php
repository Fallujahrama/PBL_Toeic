<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // If user doesn't have a level or level_kode
        if (!$user->level || !$user->level->level_kode) {
            abort(403, 'Unauthorized action.');
        }

        // If no specific roles are required, just check if user is authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has one of the required roles
        foreach ($roles as $role) {
            if ($user->level->level_kode === $role) {
                return $next($request);
            }
        }

        // If user doesn't have any of the required roles, redirect based on their role
        if (in_array($user->level->level_kode, ['AdmUpa', 'AdmITC', 'SprAdmin'])) {
            return redirect('/admin/dashboard');
        } else if ($user->level->level_kode === 'Mhs') {
            return redirect('/mahasiswa/pendaftaran');
        }

        abort(403, 'Unauthorized action.');
    }
}
