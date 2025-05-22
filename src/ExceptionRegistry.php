<?php
class ExceptionRegistry
{
    private static $map = [
        \InvalidArgumentException::class => 400,
        \PDOException::class => 503,
        \RuntimeException::class => 500,
        \Exception::class => 500
    ];

    private static $custom = [];

    public static function register(string $exceptionClass, string $message, string $code): void
    {
        self::$custom[$exceptionClass] = compact('message', 'code');
    }

    public static function resolve(\Throwable $e): array
    {
        $class = get_class($e);
        $status = self::$map[$class] ?? 500;

        return [
            'status' => $status,
            'message' => str_replace(
                '{original_message}',
                $e->getMessage(),
                self::$custom[$class]['message'] ?? $e->getMessage()
            ),
            'code' => self::$custom[$class]['code'] ?? 'UNKNOWN'
        ];
    }
}


