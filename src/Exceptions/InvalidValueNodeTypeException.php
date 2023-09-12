<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * A class to throw an exception for a bad node type
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
 class InvalidValueNodeTypeException extends Exception
 {
    /*
     * A class to throw an exception for a bad node type
     *
     * @param string $type             correct value type node
     * @param int $code                exception code
     * @param Throwable|null $previous previous exception
     */
    public function __construct(
        string $type = 'int',
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = "The value must be of type {$type}";

        parent::__construct($message, $code, $previous);
    }
}