<?php

namespace App\Serviceses;

use Illuminate\Http\JsonResponse;

class ResponseServise
{
    public static function successResponse(array $data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public static function somethingWentWrongResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'message' => 'Something went wrong',
        ], 400);
    }

    public static function notFoundResponse(string $model, string $key, string $value): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'message' => "The $model with $key=$value not found.",
        ], 404);
    }
}
