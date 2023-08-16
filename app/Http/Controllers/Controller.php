<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

     protected function success(string $message = null, $data = null) : object
     {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ]);
     }

     protected function fail(string $message = null, $data = null) : object
     {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], 422);

     }

     protected function error(string $message = null, $data = null) : object
     {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ]);
     }
}
