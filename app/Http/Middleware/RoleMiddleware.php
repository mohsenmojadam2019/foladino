<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (! in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'شما مجوز دسترسی به این بخش را ندارید.');
        }

        return $next($request);
    }
}
