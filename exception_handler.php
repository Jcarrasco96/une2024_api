<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function exception_handler($exception): void
{
    if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1' && !headers_sent()) {
        header('HTTP/1.1 503 Service Unavailable');
    }

    http_response_code($code = $exception->getCode() ?: 500);

    header('Content-Type: application/json; charset=utf8');

    echo json_encode([
        'status' => $code,
        'message' => $exception->getMessage(),
        'trace' => $exception->getTraceAsString(),
    ]);
    exit;
}
