<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

use Exception;
use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\StringLinkedList;
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
        $actual = new StringLinkedList();
        $value = 'a';

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
        $actual = new StringLinkedList();
        $actual->add('b');

        $value = 'a';

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
        $value = 'c';

        $actual = new StringLinkedList();
        $actual->add($value);
        $actual->delete($value);

        self::assertEquals(new StringLinkedList(), $actual);
        self::assertSame(0, $actual->getCount());
        self::assertEquals('StringLinkedList number of nodes: 0', $actual->__toString());
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
        $value = 'a';

        $actual = new StringLinkedList();
        for ($i = 1; $i <= 10; $i++) {
            $actual->add($value);
        }
        $actual->delete($value);

        self::assertEquals(new StringLinkedList(), $actual);
        self::assertEquals('StringLinkedList number of nodes: 0', $actual->__toString());
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
        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->delete('a');

        $expected = new StringLinkedList();
        $expected->add('b');
        $expected->add('c');
        $expected->add('d');
        $expected->add('e');

        self::assertEquals($expected, $actual);
 
        self::assertSame(
            'StringLinkedList number of nodes: 4' . PHP_EOL .
            'b (prev: null, next: c)' . PHP_EOL .
            'c (prev: b, next: d)' . PHP_EOL .
            'd (prev: c, next: e)' . PHP_EOL .
            'e (prev: d, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->add('e');

        $actual->delete('a');

        $expected = new StringLinkedList();
        $expected->add('b');
        $expected->add('c');
        $expected->add('c');
        $expected->add('d');
        $expected->add('e');
        $expected->add('e');

        self::assertEquals($expected, $actual);

        self::assertSame(
            'StringLinkedList number of nodes: 6' . PHP_EOL .
            'b (prev: null, next: c)' . PHP_EOL .
            'c (prev: b, next: c)' . PHP_EOL .
            'c (prev: c, next: d)' . PHP_EOL .
            'd (prev: c, next: e)' . PHP_EOL .
            'e (prev: d, next: e)' . PHP_EOL .
            'e (prev: e, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('a');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('c');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->add('e');
        $actual->add('e');
        $actual->delete('e');

        $expected = new StringLinkedList();
        $expected->add('a');
        $expected->add('a');
        $expected->add('a');
        $expected->add('b');
        $expected->add('c');
        $expected->add('c');
        $expected->add('c');
        $expected->add('d');

        self::assertEquals($expected, $actual);

        self::assertSame(
            'StringLinkedList number of nodes: 8' . PHP_EOL .
            'a (prev: null, next: a)' . PHP_EOL .
            'a (prev: a, next: a)' . PHP_EOL .
            'a (prev: a, next: b)' . PHP_EOL .
            'b (prev: a, next: c)' . PHP_EOL .
            'c (prev: b, next: c)' . PHP_EOL .
            'c (prev: c, next: c)' . PHP_EOL .
            'c (prev: c, next: d)' . PHP_EOL .
            'd (prev: c, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('a');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('c');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->add('e');
        $actual->add('e');
        $actual->delete('c');

        $expected = new StringLinkedList();
        $expected->add('a');
        $expected->add('a');
        $expected->add('a');
        $expected->add('b');
        $expected->add('d');
        $expected->add('e');
        $expected->add('e');
        $expected->add('e');

        self::assertEquals($expected, $actual);

        self::assertSame(
            'StringLinkedList number of nodes: 8' . PHP_EOL .
            'a (prev: null, next: a)' . PHP_EOL .
            'a (prev: a, next: a)' . PHP_EOL .
            'a (prev: a, next: b)' . PHP_EOL .
            'b (prev: a, next: d)' . PHP_EOL .
            'd (prev: b, next: e)' . PHP_EOL .
            'e (prev: d, next: e)' . PHP_EOL .
            'e (prev: e, next: e)' . PHP_EOL .
            'e (prev: e, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('a');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('c');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->add('e');
        $actual->add('e');
        $actual->delete('c', false);

        self::assertSame(
            'StringLinkedList number of nodes: 10' . PHP_EOL .
            'a (prev: null, next: a)' . PHP_EOL .
            'a (prev: a, next: a)' . PHP_EOL .
            'a (prev: a, next: b)' . PHP_EOL .
            'b (prev: a, next: c)' . PHP_EOL .
            'c (prev: b, next: c)' . PHP_EOL .
            'c (prev: c, next: d)' . PHP_EOL .
            'd (prev: c, next: e)' . PHP_EOL .
            'e (prev: d, next: e)' . PHP_EOL .
            'e (prev: e, next: e)' . PHP_EOL .
            'e (prev: e, next: null)',
            $actual->__toString()
        );
    }
}