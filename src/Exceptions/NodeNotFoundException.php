<?php declare(strict_types = 1);

namespace LinkedList\Exceptions;

use Exception;
use Throwable;

/**
 * Class for to throw an exception for not finding a node in the lis
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
        $message = "Node value = {$value} was not found";

        parent::__construct($message, $code, $previous);
    }
}