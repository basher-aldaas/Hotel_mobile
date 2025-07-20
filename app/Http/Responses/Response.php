<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Response
{

    /*
     * return success response message in the hoe project
     */
    public static function Success($data , $message , $code = 200) : JsonResponse
    {
        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => $message,
        ] , $code);
    }

    /*
     * return error response message in the hole project
     */
    public static function Error($data , $message , $code = 500) :JsonResponse
    {
        return response()->json([
            'status' => 0,
            'data' => $data,
            'message' => $message,
        ] , $code);
    }

    /*
     *return error response message for the validation errors in the hole project
     * in the normal case there is an error message for every validate but in this case the
     * compiler will put my error validate message
     */

    //لتوحيد شكل رسائل الفاليديشن
    public static function Validation($data , $message , $code = 422) : JsonResponse
    {
        return response()->json([
            'status' => 0,
            'data' => $data,
            'message' => $message,
        ] , $code);
    }

}
