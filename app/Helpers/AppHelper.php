<?php 

namespace App\Helpers;
use Str;

class AppHelper {

    public static function routeName() {
        return basename(request()->route()->getName());
    }

    public static function isCurrentRoute($route) : bool {
        return (self::routeName() == $route);
    }

    public static function isRouteGroup($route) : bool {
        return str_contains(self::routeName(), $route);
    }

    public static function isUserAuthRoute() : bool {
        return in_array(self::routeName(), ['login', 'auth.register', 'forgot_password', 'reset_password', 'auth.redirect']);
    }

    public static function isAdminAuthRoute() : bool {
        return in_array(self::routeName(), ['admin.login']);
    }

    public static function isApiRequest() : bool {
        return str_starts_with(request()->route()->getPrefix(), 'api');
    }

    public static function hasPermissionTo($permission){

        if(request()->routeIs('admin.*')){

            if(auth()->user()->can($permission)) return;

            toast()->danger("You do not have permission to access this page")->pushOnNextPage();

            if(request()->routeIs('admin.*')) return redirect()->route('admin.dashboard');
            
        }

    }

    public static function uploadFile($file, $filePath, $previousPath = null, $isupdating = false) {

        if(!$file && $isupdating) return $previousPath;// return previous path if we updating file and file upload exists

        if (file_exists($previousPath)) unlink($previousPath);

        if(!$file) return null;

        $fullFilePath = $directory = date("Y")."/".date("m")."/".date("d"). '/' . $filePath;
        
        return 'storage/' .$file->storeAs($fullFilePath, Str::uuid() . '.' .$file->extension());
    }
    

}
