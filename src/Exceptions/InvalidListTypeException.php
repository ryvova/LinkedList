<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * Třída pro vytvoření výjimky pro chybný typ seznamu
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class InvalidListTypeException extends Exception
{
    public function __construct(
        string $message = 'oba seznamy musí být stejného typu',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}