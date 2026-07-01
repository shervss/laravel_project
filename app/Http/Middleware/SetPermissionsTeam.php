<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPermissionsTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        setPermissionsTeamId($request->session()->get('permissions_team_id', 1));

        return $next($request);
    }
}
