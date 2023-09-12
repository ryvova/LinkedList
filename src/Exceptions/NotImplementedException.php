<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * Class for to throw an exception for calls to unimplemented function
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class NotImplementedException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}