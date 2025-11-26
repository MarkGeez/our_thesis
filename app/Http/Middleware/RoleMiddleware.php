<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            $user= Auth::user();

            switch ($user->role) {
                case 'admin':
                    if(!$request->is("admin/{$user->id}/*")){
                        return redirect("/admin/{$user->id}/dashboard");
                    }
                    break;
                case 'subadmin':
                    if(!$request->is("subadmin/{$user->id}/*")){
                        return redirect("/subadmin/{$user->id}/dashboard");
                    }
                    break;

                case 'resident':
                    if (!$request->is("resident/{$user->id}/*")) {
                    return redirect("/resident/{$user->id}/dashboard");
                    }
                    break;
                case 'non-resident':
                    if(!$request->is("non-resident{$user->id}/*")){
                        return redirect("/non-resident/{$user->id}/dashboard");
                    }
                    

            }


            
        }
        return $next($request);
    }
}
