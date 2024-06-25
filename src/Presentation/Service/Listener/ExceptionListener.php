<?php

declare(strict_types=1);

namespace App\Presentation\Service\Listener;

use App\Application\Exception\BadRequestException;
use App\Application\Exception\DuplicateException;
use App\Application\Exception\HttpRequestValidationException;
use App\Application\Exception\NotFoundException\UserNotFoundException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ExceptionListener
{
    private bool $debug;
    private LoggerInterface $logger;

    public function __construct(bool $debug, LoggerInterface $logger)
    {
        $this->debug = $debug;
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$this->isApiRequest($event->getRequest())) {
            return;
        }

        $exception = $event->getThrowable();

        if ($exception instanceof HttpRequestValidationException) {
            $response = $this->buildResponse(
                $exception->getStatusCode(),
                $exception,
                [
                    //'fields' => $this->buildValidationErrors($exception->getViolations()),
                    'message' => 'Data validation error',
                ]
            );
        } elseif ($exception instanceof DuplicateException) {
            $response = $this->buildResponse(Response::HTTP_BAD_REQUEST, $exception, [
                'message' => $exception->getMessage(),
            ]);
        } elseif ($exception instanceof UniqueConstraintViolationException) {
            $response = $this->buildResponse(Response::HTTP_BAD_REQUEST, $exception, [
                'message' => 'Such record already exists',
            ]);
        } elseif ($exception instanceof HttpExceptionInterface) {
            $response = $this->buildResponse($exception->getStatusCode(), $exception, [
                'message' => 'Internal server error'
            ]);
        } elseif ($exception instanceof UserNotFoundException) {
            $response = $this->buildResponse(Response::HTTP_BAD_REQUEST, $exception, [
                'message' => $exception->getMessage(),
            ]);
        } elseif ($exception instanceof ExtensionFileException) {
            $response = $this->buildResponse(Response::HTTP_BAD_REQUEST, $exception, [
                'message' => $exception->getMessage(),
            ]);
        } elseif ($exception instanceof BadRequestException) {
            $response = $this->buildResponse(Response::HTTP_BAD_REQUEST, $exception, [
                'message' => $exception->getMessage(),
            ]);
        } else {
            return;
        }

        if ($response->getStatusCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logger->critical($exception->getMessage(), ['exception' => $exception]);
        } elseif ($response->getStatusCode() >= Response::HTTP_BAD_REQUEST) {
            $this->logger->info($exception->getMessage(), ['exception' => $exception]);
        }

        $event->setResponse($response);
    }

    private function mapHttpCodeToResponseStringCode(int $httpCode): string
    {
        if (!isset(Response::$statusTexts[$httpCode])) {
            return (string)$httpCode;
        }

        return Response::$statusTexts[$httpCode];
    }

    private function isApiRequest(Request $request): bool
    {
        if (str_contains($request->getUri(), 'api/')) {
            return true;
        }

        if ($request->headers === null) {
            return false;
        }

        if (str_contains($request->headers->get('Content-Type', ''), 'application/json')) {
            return true;
        }

        if (str_contains($request->headers->get('Accept', ''), 'application/json')) {
            return true;
        }

        return false;
    }

    private function buildResponse(int $throwableCode, Throwable $throwable, array $extendedData = []): JsonResponse
    {
        $data = [
            'exception' => $throwable->getMessage(),
            'code' => $this->mapHttpCodeToResponseStringCode($throwableCode),
        ];

        $data = array_merge($data, $extendedData, $this->getDebugData($throwable));

        return new JsonResponse(
            $data,
            $throwableCode ?? Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    // private function buildValidationErrors(ConstraintViolationListInterface $violations): array
    // {
    //     $items = [];

    //     /** @var ConstraintViolationInterface $violation */
    //     foreach ($violations as $violation) {
    //         $items[$violation->getPropertyPath()] = (string)$violation->getMessage();
    //     }

    //     return $items;
    // }

    private function getDebugData(Throwable $throwable): array
    {
        $debugData = [];

        if ($this->debug) {
            $debugData['sourceCode'] = $throwable->getCode();
            $debugData['file'] = $throwable->getFile();
            $debugData['line'] = $throwable->getLine();
            $debugData['trace'] = $throwable->getTraceAsString();
            $debugData['previousMessage'] = $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : '';
        }

        return $debugData;
    }
}
