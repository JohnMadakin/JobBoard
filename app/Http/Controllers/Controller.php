<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success($message, $data = null, $code)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    
    public function error($message, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
