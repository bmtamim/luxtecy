<?php

use Illuminate\Http\JsonResponse;

if ( ! function_exists('jsonResponseFormat')) {
    function jsonResponseFormat(
        bool $success,
        mixed $payload,
        ?string $message = null,
        ?int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            'message' => $message ?: __('Request success!'),
            'payload' => $payload,
            'status'  => $status,
        ], $status);
    }
}
