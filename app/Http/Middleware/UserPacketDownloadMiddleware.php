<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPacketDownloadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()){
            abort(403);
        }
        $user = auth()->user();
        if($user->role == User::APPLICANT){
            $pass = $user->id == $request->id;
            if(!$pass){
                abort(403);
            }
        }
        if(!User::find($request->id)->canBeZipped()){
            abort(403);
        }
        return $next($request);

    }
}
