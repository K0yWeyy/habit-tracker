<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user mengakses dari welcome page (via tombol)
        if (!$request->session()->has('access_granted')) {
            return redirect()->route('welcome');
        }
        
        return $next($request);
    }
}