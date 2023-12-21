<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBlocked
{
    public function handle($request, Closure $next)
    {
        if(auth()->check() && auth()->user()->isBlocked()){
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login');

        }

    return $next($request);
}
}

