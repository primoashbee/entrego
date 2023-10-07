<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicantTakenAssessment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user->role == 'APPLICANT' && !$user->hasFinishedAssessment() && $user->has_finished_profile){
            return redirect()->route('personal-assessments.create');
        }
        return $next($request);
    }
}
