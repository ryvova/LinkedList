<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Throwable;

/**
 * A class for an invalid Node value to throw an exception
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class InvalidValueNodeException extends \Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}