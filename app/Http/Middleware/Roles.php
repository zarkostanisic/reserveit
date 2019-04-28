<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $mode = 'web')
    {
        $user = $request->user();

        $roles = explode('|', $roles);

        foreach($roles as $role){

            if ($user->role->name == $role) {
                return $next($request);
            }
        }

        return $mode == 'api' ? response()->json(['data' => 'Forbidden.'],  Response::HTTP_FORBIDDEN) : redirect('/dashboard');
    }
}
