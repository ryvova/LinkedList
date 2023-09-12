<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * A class to throw an exception for a bad list type
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class InvalidListTypeException extends Exception
{
    public function __construct(
        string $message = 'both lists must be of the same type',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}