<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $token = $request->session()->get('token');
        if (!$token) {
            // Token tidak ada, arahkan ke halaman login atau lakukan tindakan lain sesuai kebutuhan
            return redirect('/dokter/login');
        } 
        return $next($request);
    }
}
