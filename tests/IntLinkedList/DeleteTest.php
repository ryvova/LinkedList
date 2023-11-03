<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use Exception;
use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\IntLinkedList;
use PHPUnit\Framework\TestCase;

/**
 * A class for testing the delete() method using PHPUnit tests
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class DeleteTest extends TestCase
{
    /**
     * Test for deleting a value from an empty list
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteFromEmptyList(): void
    {
        $actual = new IntLinkedList();
        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->delete($value);
        self::assertSame('', $actual->__toString());
        self::assertSame(0, $actual->getCount());
    }

    /**
     * Test to delete a value that is not in the list
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteValueWhichNotInList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);

        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->delete($value);

        self::assertSame('', $actual->__toString());
        self::assertSame(0, $actual->getCount());
    }

    /**
     * Test to delete a value from a list containing 1 value
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testListContainsOneNode(): void
    {
        $value = 3;

        $actual = new IntLinkedList();
        $actual->add($value);
        $actual->delete($value);

        self::assertEquals(new IntLinkedList(), $actual);
        self::assertSame(0, $actual->getCount());
        self::assertEquals('IntLinkedList number of nodes: 0', $actual->__toString());
    }

    /**
     * Test to delete a value from a list containing the same values
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testAllValuesInListIsSame(): void
    {
        $value = 1;

        $actual = new IntLinkedList();
        for ($i = 1; $i <= 10; $i++) {
            $actual->add($value);
        }
        $actual->delete($value);

        self::assertEquals(new IntLinkedList(), $actual);
        self::assertSame(0, $actual->getCount());
        self::assertEquals('IntLinkedList number of nodes: 0', $actual->__toString());
    }

    /**
     * Test to delete the first value of the list
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteFirstValue(): void
    {
        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }
        $actual->delete(1);

        $expected = new IntLinkedList();
        for ($i = 2; $i <= 5; $i++) {
            $expected->add($i);
        }

        self::assertEquals($expected, $actual);
        self::assertSame(4, $actual->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 4' . PHP_EOL .
            '2 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test deleting multiple values from the beginning of the list
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteMoreValuesFromBegin(): void
    {
        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(1);

        $expected = new IntLinkedList();
        for ($i = 2; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 8' . PHP_EOL .
            '2 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test for deleting multiple values from the end of the list
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteMoreValueFromEnd(): void
    {
        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(5);

        $expected = new IntLinkedList();
        for ($i = 1; $i <= 4; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 8' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test deleting multiple values from a list resource
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteFromMiddle(): void
    {
        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(3);

        $expected = new IntLinkedList();
        for ($i = 1; $i <= 2; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        for ($i = 4; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 8' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 4)' . PHP_EOL .
            '4 (prev: 2, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test to delete only one value in case of multiple duplicate values
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function testDeleteOnlyOneValue(): void
    {
        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(3, false);

        self::assertSame(
            'IntLinkedList number of nodes: 10' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }
}