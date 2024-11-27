<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HandlesApiExceptions
{
    /**
     * Handle exceptions and return a JSON response.
     */
    public function handleException(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $exception->errors(),
            ], 422);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'The requested resource could not be found.',
            ], 404);
        }

        if ($exception instanceof \InvalidArgumentException) {
            return response()->json([
                'error' => 'Invalid Argument',
                'message' => $exception->getMessage(),
            ], 400);
        }

        return response()->json([
            'error' => 'Server Error',
            'message' => 'An unexpected error occurred.',
        ], 500);
    }
}
