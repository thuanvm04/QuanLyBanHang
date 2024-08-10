<?php
namespace App\Http\Middleware;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Closure;

class CheckRoleAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth ::check() && Auth::user()->role === User::ROLE_ADMIN) {
            return $next($request);
        }
      abort(403);
    }
}
