<?php

namespace App\Http\Middleware;

use App\Helpers\GarlitoApiResponseHelper;
use App\Models\User;
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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        // Return Unauthenticated Response
        if(!Auth::check()){ return GarlitoApiResponseHelper::getUnauthorizedResponse();}

        // Get User's Role Slug.
        $auth_role = User::find(Auth::id())->role->slug;

        // If Current User Does not Belong in the provided role list.
        if (!in_array($auth_role, $roles)) { return GarlitoApiResponseHelper::getForbiddenResponse(); }

        // Return Next Request If Everything is ok.
        return $next($request);
    }
}
