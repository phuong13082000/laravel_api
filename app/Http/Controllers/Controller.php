<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function responseSuccess($data, $message = '', $status = 'success'): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ]);
    }

    protected function responseError($message = '', $status = 'error'): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'data' => [],
            'message' => $message,
        ]);
    }
}
