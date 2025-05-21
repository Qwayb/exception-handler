<?php

namespace qwayb\ExceptionHandler;

class ExceptionHandler
{
    /**
     * @var callable|null
     */
    private $exceptionFormatter;

    /**
     * @param callable|null $exceptionFormatter Функция для форматирования исключения
     */
    public function __construct(callable $exceptionFormatter = null)
    {
        $this->exceptionFormatter = $exceptionFormatter;
    }

    /**
     * Выполняет код с обработкой исключений
     *
     * @param callable $action
     * @return array
     */
    public function handle(callable $action): array
    {
        try {
            $result = $action();
            return [
                'success' => true,
                'data' => $result,
                'error' => null
            ];
        } catch (\Throwable $e) {
            return $this->formatException($e);
        }
    }

    /**
     * Форматирует исключение в массив
     *
     * @param \Throwable $e
     * @return array
     */
    protected function formatException(\Throwable $e): array
    {
        if ($this->exceptionFormatter) {
            return (array)call_user_func($this->exceptionFormatter, $e);
        }

        // Стандартный формат
        return [
            'success' => false,
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'fields' => method_exists($e, 'getFields') ? $e->getFields() : [],
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ]
        ];
    }
}