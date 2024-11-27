<?php

namespace App\Services\Response;

class ResponseBuilder
{
    protected $success;
    protected $message;
    protected $data;
    protected $httpCode;

    /**
     * Create a new ResponseBuilder instance.
     *
     * @param mixed $success
     * @param string $message
     * @param mixed $data
     * @param int $httpCode
     */
    public function __construct($success, $message, $data, $httpCode)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->httpCode = $httpCode;
    }

    /**
     * Build the response array based on the conditions.
     *
     * @param array $payload
     * @return \Illuminate\Http\JsonResponse
     */
    public function buildResponse(array $payload): \Illuminate\Http\JsonResponse
    {
        // Initialize the result array
        $result = [
            'success' => $this->success ?? null,
        ];

        // Conditionally add 'data' and 'message' if 'data' is present
        if ($this->data && isset($payload['data'])) {
            $result['message'] = ucfirst($this->message ?? '');
            $result['data'] = $payload['data'];
        } else {
            // If 'data' is missing, check if 'message' should still be included
            if (isset($this->message)) {
                $result['message'] = ucfirst($this->message);
            }
            // Include 'error' if it exists
            if (isset($payload['error'])) {
                $result['error'] = isset($payload['validationEx']) ? $payload['validationEx'] : ucfirst($payload['error']);
            }
        }
        $result['status'] = $this->httpCode;

        // Remove null values
        $result = array_filter($result, fn($value) => $value !== null);
        return response()->json(
            data: $result,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );

    }
}
