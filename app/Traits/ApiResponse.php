<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function response;

trait ApiResponse
{
    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function respond(array $data, int $status = ResponseAlias::HTTP_OK, array $headers = []): JsonResponse
    {
        return response()->json($data, $status, $headers)->header('Content-Type', 'application/json');
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @param array $additionalData
     * @return JsonResponse
     */
    protected function respondWithError(string $message, int $status = ResponseAlias::HTTP_BAD_REQUEST, array $headers = [], array $additionalData = []): JsonResponse
    {
        return $this->respond([
            'error' => [
                'error_data' => $additionalData,
                'message' => $message,
                'status_code' => $status,
            ],
        ], $status, $headers);
    }
}
