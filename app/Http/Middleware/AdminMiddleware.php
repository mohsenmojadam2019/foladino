<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->is_active || ! in_array(auth()->user()->role, ['super_admin','admin','pricing','content'])) {
            return redirect()->route('admin.login')->with('error', 'برای دسترسی به پنل وارد شوید.');
        }
        return $next($request);
    }
}
