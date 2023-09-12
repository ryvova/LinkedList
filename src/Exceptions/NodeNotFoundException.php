<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * Třída pro pro vytvoření výjimky pro nenalezení nodu v seznamu
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class NodeNotFoundException extends Exception
{
    public function __construct(
        int|string $value,
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = "Node {$value} nebyl nalezen";

        parent::__construct($message, $code, $previous);
    }
}