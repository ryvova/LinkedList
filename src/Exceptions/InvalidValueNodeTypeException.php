<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * Výjimka pro chybný typ hodnoty Node v seznamu
 */
class InvalidValueNodeTypeException extends Exception
{
    /**
     * @param string $type             správný typ hodnoty Node
     * @param int $code                kód výjimky
     * @param Throwable|null $previous předchozí výjimka
     */
    public function __construct(
        string $type = 'int',
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = "Hodnota musí být typu {$type}";

        parent::__construct($message, $code, $previous);
    }

    /**
     * Vypíše výjimku jako text
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": \n  kód: {$this->code}, \n  message: {$this->message}\n";
    }
}