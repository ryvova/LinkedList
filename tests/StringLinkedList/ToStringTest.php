<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

use LinkedList\StringLinkedList;
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
        $list = new StringLinkedList();

        self::assertSame('StringLinkedList number of nodes: 0', $list->__toString());
    }

    /**
     * Test for writing a list containing 1 node
     *
     * @return void
     */
    public function testListWithOneNode(): void
    {
        $actual = new StringLinkedList();
        $actual->add('bla bla bla');

        self::assertSame(
            'StringLinkedList number of nodes: 1' . PHP_EOL .
            'bla bla bla (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test for writing a list containing 2 nodes
     *
     * @return void
      */
    public function testListWithTwoNode(): void
    {
        $actual = new StringLinkedList();
        $actual->add('b');
        $actual->add('a');

        self::assertSame(
            'StringLinkedList number of nodes: 2' . PHP_EOL .
            'a (prev: null, next: b)' . PHP_EOL .
            'b (prev: a, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test for writing a list containing more than 2 nodes
     *
     * @return void
     */
    public function testListWithMoreThanTwoNodes(): void
    {
        $actual = new StringLinkedList();
        $actual->add('d');
        $actual->add('c');
        $actual->add('e');
        $actual->add('b');
        $actual->add('a');

        self::assertSame(
            'StringLinkedList number of nodes: 5' . PHP_EOL .
            'a (prev: null, next: b)' . PHP_EOL .
            'b (prev: a, next: c)' . PHP_EOL .
            'c (prev: b, next: d)' . PHP_EOL .
            'd (prev: c, next: e)' . PHP_EOL .
            'e (prev: d, next: null)',
            $actual->__toString()
        );
    }
 }