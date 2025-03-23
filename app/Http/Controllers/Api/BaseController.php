<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Success response method.
     */
    public function sendResponse($result = null, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result ?? null, // Pastikan `null` jika kosong
            'message' => $message,
        ], $code);
    }

    /**
     * Return error response.
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
            'data'    => !empty($errorMessages) ? $errorMessages : null, // Pastikan `null` jika kosong
        ];

        return response()->json($response, $code);
    }
}
