<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Tambahkan 'string' sebelum $role
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Periksa apakah user sudah login dan perannya (role) sesuai dengan yang diminta
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Jika tidak sesuai, tolak akses dengan error 403 Forbidden
        abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk melihat halaman ini.');
    }
}