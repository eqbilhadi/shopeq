<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Rbac\app\Models\Menu;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentController = request()->route()->getControllerClass();

        $user = auth()->user();

        $access = Menu::whereControllerName($currentController)->whereIsActive(1)
                ->whereHas('roles', fn($query) => $query->whereIn('role_id', $user->roles->pluck('id')))
                ->first();

        return $access ? $next($request) : abort(403, 'Dont Have Access To This Url');
    }
}
