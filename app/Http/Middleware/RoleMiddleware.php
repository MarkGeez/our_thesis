<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Resident;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(404);
        }

        // Keep role in sync: once a non-resident is encoded as resident, promote automatically.
        if ($user->role === 'non-resident') {
            $resident = Resident::where('user_id', $user->id)->first();

            if (!$resident) {
                $resident = Resident::matchingUser($user)
                    ->first();
            }

            if ($resident) {
                if (!$resident->user_id) {
                    $resident->update(['user_id' => $user->id]);
                }
                $user->update(['role' => 'resident']);
                $user->refresh();
            }
        }

        if ($user->role !== $role) {
            if ($user->role === 'resident') {
                return redirect('/resident/dashboard');
            }
            if ($user->role === 'non-resident') {
                return redirect('/non-resident/dashboard');
            }
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            if ($user->role === 'subadmin') {
                return redirect('/subadmin/dashboard');
            }
            abort(404);
        }

        return $next($request);
    }
}
