<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function raw(array $data = []): JsonResponse
    {
        return response()->json($data);
    }

    public static function send(bool $success, string|null $message = null, array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function success(string|array $message = [], array $data = []): JsonResponse
    {
        if (gettype($message) === 'array') {
            $data = $message;
            $message = 'Success';
        }
        return self::send(true, $message, $data);
    }

    public static function created(string|array $message = [], array $data = []): JsonResponse
    {
        if (gettype($message) === 'array') {
            $data = $message;
            $message = 'Created';
        }
        return self::send(true, $message, $data, 201);
    }

    public static function badRequest(string|array $message = [], array $data = []): JsonResponse
    {
        if (gettype($message) === 'array') {
            $data = $message;
            $message = 'Bad Request';
        }
        return self::send(false, $message, $data, 400);
    }

    public static function unauthorized(string|array $message = [], array $data = []): JsonResponse
    {
        if (gettype($message) === 'array') {
            $data = $message;
            $message = 'Unauthorized';
        }
        return self::send(false, $message, $data, 401);
    }
}
