<?php declare(strict_types = 1);

namespace LinkedList\Tests\LinkedList;

use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\LinkedList;
use PHPUnit\Framework\TestCase;

/**
 * A class for testing the __toString() method using PHPUnit tests
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class ToStringTest extends TestCase
{
    /**
     * Test for writing an empty list as a string
     *
     * @return void
     */
    public function testEmptyList(): void
    {
        $list = new LinkedList();

        self::assertSame('LinkedList number of nodes: 0, values type: int', $list->__toString());
    }

    /**
     * Test for writing a list containing 1 node
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testListWithOneNode(): void
    {
        $actual = new LinkedList();
        $actual->add(7);

        self::assertSame(
            'LinkedList number of nodes: 1, values type: int' . PHP_EOL .
            '7 (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test for writing a list containing 2 nodes
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testListWithTwoNode(): void
    {
        $actual = new LinkedList();
        $actual->add(2);
        $actual->add(1);

        self::assertSame(
            'LinkedList number of nodes: 2, values type: int' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test for writing a list containing more than 2 nodes
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testListWithMoreThanTwoNodes(): void
    {
        $actual = new LinkedList();
        $actual->add(4);
        $actual->add(3);
        $actual->add(5);
        $actual->add(2);
        $actual->add(1);

        self::assertSame(
            'LinkedList number of nodes: 5, values type: int' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: null)',
            $actual->__toString()
        );
    }
 }