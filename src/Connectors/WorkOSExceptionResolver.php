<?php

declare(strict_types=1);

namespace NjoguAmos\LaravelWorkOS\Connectors;

use NjoguAmos\LaravelWorkOS\Exceptions\BadRequestException;
use NjoguAmos\LaravelWorkOS\Exceptions\ForbiddenException;
use NjoguAmos\LaravelWorkOS\Exceptions\GatewayTimeoutException;
use NjoguAmos\LaravelWorkOS\Exceptions\InternalServerErrorException;
use NjoguAmos\LaravelWorkOS\Exceptions\NotFoundException;
use NjoguAmos\LaravelWorkOS\Exceptions\RequestTimeOutException;
use NjoguAmos\LaravelWorkOS\Exceptions\ServiceUnavailableException;
use NjoguAmos\LaravelWorkOS\Exceptions\UnauthorizedException;
use NjoguAmos\LaravelWorkOS\Exceptions\UnprocessableEntityException;
use NjoguAmos\LaravelWorkOS\Exceptions\WorkOSRequestException;
use Saloon\Http\Response;
use Throwable;

class WorkOSExceptionResolver
{
    public function getRequestException(Response $response, ?Throwable $senderException): WorkOSRequestException
    {
        return match ($response->status()) {
            400 => new BadRequestException(
                response: $response,
                message: trans(key: 'workos::workos.errors.400'),
                code: $response->status(),
                previous: $senderException,
            ),
            401 => new UnauthorizedException(
                response: $response,
                message: trans(key: 'workos::workos.errors.401'),
                code: $response->status(),
                previous: $senderException,
            ),
            403 => new ForbiddenException(
                response: $response,
                message: trans(key: 'workos::workos.errors.403'),
                code: $response->status(),
                previous: $senderException,
            ),
            404 => new NotFoundException(
                response: $response,
                message: trans(key: 'workos::workos.errors.404'),
                code: $response->status(),
                previous: $senderException,
            ),
            408 => new RequestTimeOutException(
                response: $response,
                message: trans(key: 'workos::workos.errors.408'),
                code: $response->status(),
                previous: $senderException,
            ),
            422 => new UnprocessableEntityException(
                response: $response,
                message: trans(key: 'workos::workos.errors.422'),
                code: $response->status(),
                previous: $senderException,
            ),
            500 => new InternalServerErrorException(
                response: $response,
                message: trans(key: 'workos::workos.errors.500'),
                code: $response->status(),
                previous: $senderException,
            ),
            503 => new ServiceUnavailableException(
                response: $response,
                message: trans(key: 'workos::workos.errors.503'),
                code: $response->status(),
                previous: $senderException,
            ),
            504 => new GatewayTimeoutException(
                response: $response,
                message: trans(key: 'workos::workos.errors.504'),
                code: $response->status(),
                previous: $senderException,
            ),
            default => new WorkOSRequestException(
                response: $response,
                message: $response->getPsrResponse()->getReasonPhrase(),
                code: $response->status(),
                previous: $senderException,
            )
        };
    }
}
