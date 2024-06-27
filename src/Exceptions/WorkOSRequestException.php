<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Exceptions;

use Exception;
use Saloon\Helpers\StatusCodeHelper;
use Saloon\Http\PendingRequest;
use Saloon\Http\Response;
use Throwable;

class WorkOSRequestException extends Exception
{
    protected ?Response $response;

    public function __construct(?Response $response = null, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getPendingRequest(): PendingRequest
    {
        return $this->getResponse()->getPendingRequest();
    }

    public function getStatus(): int
    {
        return $this->response->status();
    }

    public function getStatusMessage(): ?string
    {
        return StatusCodeHelper::getMessage($this->getStatus());
    }
}
