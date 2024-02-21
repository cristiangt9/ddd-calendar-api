<?php

namespace App\Traits;

trait ApiResponseTrait
{
    
    /**
     * Create a new JSON response.
     *
     * @param  bool  $success
     * @param  array  $data
     * @param  int  $httpCode
     * @param  int  $codError
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    
    public function defaultResponse($success = true, $data = [], $httpCode = 200, $codError = 00, $message = "")
    {
        return response(
            [
                "success" => $success,
                "cod_error" => $codError,
                "message" => $message,
                "data" => $data,
            ], $httpCode
        )->header('Content-Type', 'application/json');
    }
    
    /**
     * Create a new JSON response.
     *
     * @param  string  $message
     * @param  array  $data
     * @param  int  $httpCode
     * @param  int  $codError
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($message, $data = [], $httpCode = 404, $codError = 00)
    {
        return response([
            "success" => false,
            "cod_error" => $codError,
            "message" => $message,
            "data" => $data
        ],
        $httpCode
        )->header('Content-Type', 'application/json');
    }
}
