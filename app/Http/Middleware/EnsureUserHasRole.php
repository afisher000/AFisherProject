<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        # Not logged in as admin
        if (!$request->user() || !$request->user()->hasRole($role)) {
            session(['url.intended' => url()->previous()]);
            return redirect('users/accessdenied');
        }
        // # User doesn't have admin role
        // else if (! $request->user()->hasRole($role)) {
        //     return redirect('users/accessdenied');
        // }
 
        return $next($request);
    }
 
}