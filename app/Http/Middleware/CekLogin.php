<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CekLogin
{
    public function handle(Request $request, Closure $next): Response 
    {
    if (!Session::has('login_sebagai')) {
        return redirect('/')->with('error', 'akses ditolak! silakan login kembali');
    }
    return $next($request);
    
    }
}
