<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Единственная защищённая паролем область — админка, поэтому неавторизованных
        // отовсюду возвращаем на её страницу входа.
        return $request->expectsJson() ? null : route('admin.login');
    }
}
