<?php 
namespace App\Traits;

trait ApiResponseTrait {
    
    public function apiResponse( $data = null, $message='', $status = 200) {

        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ]);
    }
}