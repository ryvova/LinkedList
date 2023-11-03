<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use Exception;
use LinkedList\IntLinkedList;
use PHPUnit\Framework\TestCase;

/**
 * A class for testing add value to the begin of a list
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class UnshiftTest extends TestCase
{
    /**
     * Test adding a value to the beginning of an empty list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftIntoEmptyList(): void
    {
        $actual = new IntLinkedList();
        $actual->unshift(1);

        self::assertSame(
            'IntLinkedList number of nodes: 1' . PHP_EOL .
            '1 (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test adding a value to the beginning of a int list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftIntoIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(3);
        $actual->unshift(1);

        self::assertSame(
            'IntLinkedList number of nodes: 3' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: null)',
            $actual->__toString()
        );
    }
    
    /**
     * Test adding a big value to the beginning of a int list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testInsertBigValueToIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(3);

        $expectedException = new Exception('Can\'t add to begin, use add()');
        $this->expectExceptionObject($expectedException);

        $actual->unshift(4);

        self::assertTrue(true);
    }
    
    /**
     * Test adding a string value to the beginning of a int list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftInvalidTypeValueInIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(3);

        $message = 
            'LinkedList\IntLinkedList::unshift(): ' . 
            'Argument #1 ($value) must be of type int, string given, ' .
            'called in C:\xampp\htdocs\LinkedList\tests\IntLinkedList\UnshiftTest.php on line 101';   

        $this->expectErrorMessage($message);
        
        /** @phpstan-ignore argument.type */
        $actual->unshift('bota');

        self::assertTrue(true);
    }
}