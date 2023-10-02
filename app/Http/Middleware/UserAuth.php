<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use AppHelper;

class UserAuth
{

        public function handle(Request $request, Closure $next)
        {
            if(AppHelper::isUserAuthRoute() && is_user_logged_in()){
                return redirect()->route('user.dashboard');
            }else if(!AppHelper::isUserAuthRoute() && !auth()->check()){
                   return redirect()->route('login');
            }else if(!AppHelper::isUserAuthRoute() && auth()->check()){
                if(!is_user_logged_in()){
                     return redirect()->route('login');
                }
            }          

            return $next($request);
        }

}
