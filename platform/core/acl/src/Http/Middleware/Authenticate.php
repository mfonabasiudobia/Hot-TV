<?php

namespace Botble\ACL\Http\Middleware;

use App\Enums\User\RoleEnum;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class Authenticate extends BaseAuthenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        if(!(auth()->user()->inRole(RoleEnum::SUBSCRIBER->value)
            ||
            auth()->user()->inRole(RoleEnum::DRIVER->value)
            ||
            auth()->user()->inRole('developer')
            ||
            auth()->user()->inRole('admin')

            )

        ) {
        //if(!in_array(auth()->user()->roles[0]->id, admin_id_array())){
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (! $guards) {
            $route = $request->route();
            $flag = $route->getAction('permission');
            if ($flag === null) {
                $flag = $route->getName();
            }

            $flag = preg_replace('/.create.store$/', '.create', $flag);
            $flag = preg_replace('/.edit.update$/', '.edit', $flag);

            if ($flag && ! $request->user()->hasAnyPermission((array)$flag)) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }

                return redirect()->route('dashboard.index');
            }
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('access.login');
        }
    }
}
