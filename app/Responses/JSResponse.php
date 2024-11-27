<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Throwable;
use App\Services\Response\ResponseBuilder;

class JSResponse implements Responsable
{
    const VALIDATE_MSG = 'Validation errors';
    protected int $httpCode;
    protected array $data;
    protected string $message;
    protected bool $success;
    private Throwable|MessageBag|null $exception;
    private array $headers;
    private array $metadata;

    public function __construct(
        int        $httpCode,
        array      $data = [],
        string     $message = '',
        Throwable|MessageBag $exception = null,
        array      $headers = [],
        array      $metadata = []
    )
    {
        if (!(($httpCode >= Response::HTTP_OK && $httpCode < Response::HTTP_MULTIPLE_CHOICES) ||
            ($httpCode >= Response::HTTP_BAD_REQUEST && $httpCode <= Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED))) {
            self::runTimeException($httpCode . ' is not valid');
        }

        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->message = $message;
        $this->success = $this->isSuccessStatus($httpCode);
        $this->exception = $exception;
        $this->headers = $headers;
        $this->metadata = $metadata;
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        $payload = match (true) {
            $this->httpCode >= Response::HTTP_INTERNAL_SERVER_ERROR => ['error' => 'Server error'], //if you don't show server errors to all
            $this->httpCode >= Response::HTTP_BAD_REQUEST => ['error' => $this->message],
            $this->httpCode >= Response::HTTP_OK => ['data' => $this->data],
        };

        if ($this->exception instanceof MessageBag) {
            $payload['validationEx'] =  $this->exception;
        } else {
            if (!is_null($this->exception) && config('app.debug')) {
                $payload['exception'] = $this->getDebugInformation();
                Log::error($this->message, $payload);
            }
        }


//        if ($this->data) {
//            $result = ['success' => $this->success, 'message' => ucfirst($this->message), 'data' => $payload['data'], 'status' => $this->httpCode];
//        } else {
//            $result = ['success' => $this->success, 'error' => ucfirst($payload['error']), 'status' => $this->httpCode];
//        }

        $response = app(ResponseBuilder::class, [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'httpCode' => $this->httpCode,
        ])->buildResponse($payload);

        return $this->newResponse($response, $this->httpCode);
    }

    public static function success(array $data = [], string $message = '', array $metadata = [], int $code = Response::HTTP_OK): self
    {
        return new self($code, $data, $message, null, [], $metadata);
    }
    public static function ok(string $message = '', array $metadata = []): self
    {
        return new self(Response::HTTP_OK, [], $message, null, [], $metadata
        );
    }

    public static function error(string $message, ?Throwable $exception = null, int $code = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): self
    {
        return new self($code, [], $message, $exception, $headers);
    }

    public static function invalidArgument(string $errorMessage, int $code = Response::HTTP_BAD_REQUEST): self
    {
        return new self($code, [], $errorMessage);
    }

    public static function runTimeException(string $errorMessage, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): self
    {
        return new self($code, [], $errorMessage);
    }

    public static function validationError(?MessageBag $errors): self
    {
        return new self(Response::HTTP_UNPROCESSABLE_ENTITY, [], self::VALIDATE_MSG , $errors);
    }

    public static function notFoundException(string $errorMsg): self
    {
        return new self(Response::HTTP_NOT_FOUND, [], $errorMsg);
    }

    public static function methodNotAllowedHttpException(string $errorMsg): self
    {
        return new self(Response::HTTP_METHOD_NOT_ALLOWED, [], $errorMsg);
    }

    public static function authenticationException(string $errorMsg, int $code = Response::HTTP_UNAUTHORIZED): self
    {
        return new self($code, [], $errorMsg);
    }


    private function newResponse(JsonResponse $response, int $code = Response::HTTP_OK)
    {
        return match (true) {
            $code === Response::HTTP_UNPROCESSABLE_ENTITY => throw new HttpResponseException($response),
//            $code === Response::HTTP_BAD_REQUEST => throw new \InvalidArgumentException($this->message),
//            $code === Response::HTTP_INTERNAL_SERVER_ERROR => throw new \RuntimeException($this->message),
            default => $response
        };
    }

    private function isSuccessStatus(int $httpCode): bool
    {
        return $httpCode >= Response::HTTP_OK && $httpCode < Response::HTTP_MULTIPLE_CHOICES;
    }

    private function getDebugInformation(): array
    {
        return [
            'message' => $this->exception->getMessage(),
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            'trace' => $this->exception->getTraceAsString(),
        ];
    }
}
