<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use AppHelper;

class UserAuth
{

        public function handle(Request $request, Closure $next)
        {
            if(AppHelper::isUserAuthRoute() && auth()->check()){
                // if(auth()->user()->hasRole('normal')){
                    return redirect()->route('user.dashboard');
                // }  
                return redirect()->route('login');
            }else if(!AppHelper::isUserAuthRoute() && !auth()->check()){
                   return redirect()->route('login');
            }          

            return $next($request);
        }

}
