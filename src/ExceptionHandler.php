<?php

namespace Qwayb\ExceptionHandler;

class ExceptionHandler
{
    /**
     * Обработка блока кода с перехватом исключений
     */
    public static function handle(callable $callback, ?callable $customFormatter = null): array
    {
        try {
            return [
                'success' => true,
                'data' => $callback()
            ];
        } catch (\Throwable $e) {
            $error = ExceptionRegistry::resolve($e);

            if ($customFormatter) {
                return $customFormatter($error, $e);
            }

            return [
                'success' => false,
                'error' => $error
            ];
        }
    }
}