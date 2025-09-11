<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // 👇 aquí decides a dónde mandar si no está logueado
        return $request->expectsJson() ? null : url('/');
    }
}
