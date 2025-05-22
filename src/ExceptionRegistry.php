<?php

namespace Qwayb\ExceptionHandler;

class ExceptionRegistry
{
    private static $exceptions = [];
    private static $defaultStatus = 500;

    /**
     * Регистрация нового типа исключения
     */
    public static function register(string $exceptionClass, array $config): void
    {
        self::$exceptions[$exceptionClass] = [
            'status' => $config['status'] ?? self::$defaultStatus,
            'message' => $config['message'] ?? '{original_message}',
            'code' => $config['code'] ?? 'UNKNOWN_ERROR'
        ];
    }

    /**
     * Разрешение исключения в массив с данными
     */
    public static function resolve(\Throwable $e): array
    {
        $exceptionClass = get_class($e);

        foreach (self::$exceptions as $class => $config) {
            if ($e instanceof $class) {
                return [
                    'status' => $config['status'],
                    'message' => str_replace(
                        '{original_message}',
                        $e->getMessage(),
                        $config['message']
                    ),
                    'code' => $config['code'],
                    'exception' => $exceptionClass
                ];
            }
        }

        return [
            'status' => self::$defaultStatus,
            'message' => $e->getMessage(),
            'code' => 'UNHANDLED_ERROR',
            'exception' => $exceptionClass
        ];
    }

    /**
     * Установка статуса по умолчанию
     */
    public static function setDefaultStatus(int $status): void
    {
        self::$defaultStatus = $status;
    }
}