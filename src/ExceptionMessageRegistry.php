<?php

namespace Qwayb\ExceptionHandler;

class ExceptionMessageRegistry
{
    private static array $messages = [];

    public static function registerMessage(int $code, string $message, int $status = 500): void
    {
        self::$messages[$code] = [
            'message' => $message,
            'status'  => $status,
        ];
    }

    public static function getMessage(int $code): ?array
    {
        return self::$messages[$code] ?? null;
    }
}
