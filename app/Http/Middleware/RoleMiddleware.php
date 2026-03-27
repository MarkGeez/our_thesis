<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    private function resolveLinkedResident($user): ?Resident
    {
        $resident = Resident::where('user_id', $user->id)->first();

        if (!$resident) {
            $resident = Resident::matchingUser($user)->first();
        }

        return $resident;
    }

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

        if (strtolower((string) $user->status) !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $statusMessage = match (strtolower((string) $user->status)) {
                'pending' => 'Your account is still pending approval.',
                'declined', 'rejected' => 'Your account was not approved. Please contact the barangay office.',
                default => 'Your account does not have access yet.',
            };

            return redirect()->route('login')->with('status', $statusMessage);
        }

        $linkedResident = $this->resolveLinkedResident($user);

        if ($linkedResident && strtolower((string) $linkedResident->status) === 'inactive') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('status', 'Access is unavailable because your linked resident record is marked inactive.');
        }

        // Keep role in sync: once a non-resident is encoded as resident, promote automatically.
        if ($user->role === 'non-resident') {
            $resident = $linkedResident;

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
