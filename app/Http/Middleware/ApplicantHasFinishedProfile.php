<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicantHasFinishedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $uri  = $request->route()->uri; 

        if(!$user->has_finished_profile && $user->role == User::APPLICANT && $uri != 'profile'){
            return redirect()->route('profile.edit');
        }
        return $next($request);
    }
}
