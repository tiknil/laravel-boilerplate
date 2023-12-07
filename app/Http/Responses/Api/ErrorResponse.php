<?php

namespace App\Http\Responses\Api;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    public static function json(
        int $httpStatus,
        ApiError $error,
        ?string $details = '',
        $meta = null
    ): JsonResponse {
        return new JsonResponse([
            'error' =>
                [
                    'status' => $httpStatus,
                    'code' => $error->value,
                    'title' => $error->name,
                    'details' => $details,
                    'meta' => $meta,
                ],
        ], $httpStatus);
    }

    public static function notFound(?string $message = '', $meta = null): JsonResponse
    {
        return self::json(404, ApiError::ResourceNotFound, $message, $meta);
    }

    public static function unauthorized(?string $message = '', $meta = null): JsonResponse
    {
        return self::json(401, ApiError::Unauthorized, $message, $meta);
    }

    public static function forbidden(?string $message = '', $meta = null): JsonResponse
    {
        return self::json(403, ApiError::Forbidden, $message, $meta);
    }

    public static function invalidRequest(?string $message = '', $meta = null): JsonResponse
    {
        return self::json(422, ApiError::InvalidRequest, $message ?: 'Wrong data in the request', $meta);
    }
}
