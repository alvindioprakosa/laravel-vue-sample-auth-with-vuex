<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Send a successful response.
     *
     * @param mixed|null $result
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($result = null, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result ?? null,
            'message' => $message,
        ], $code);
    }

    /**
     * Send an error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
            'data'    => !empty($errorMessages) ? $errorMessages : null,
        ], $code);
    }
}
