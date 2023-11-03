<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

use Exception;
use LinkedList\StringLinkedList;
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
        $actual = new StringLinkedList();
        $actual->unshift('abc');

        self::assertSame(
            'StringLinkedList number of nodes: 1' . PHP_EOL .
            'abc (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test adding a value to the beginning of a string list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftIntoStringList(): void
    {
        $actual = new StringLinkedList();
        $actual->add('dláto');
        $actual->add('dlažba');
        $actual->unshift('čepice');

        self::assertSame(
            'StringLinkedList number of nodes: 3' . PHP_EOL .
            'čepice (prev: null, next: dláto)' . PHP_EOL .
            'dláto (prev: čepice, next: dlažba)' . PHP_EOL .
            'dlažba (prev: dláto, next: null)',
            $actual->__toString()
        );
    }
    
    /**
     * Test adding a big value to the beginning of a string list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testInsertBigValueToStringList(): void
    {
        $actual = new StringLinkedList();
        $actual->add('auto');
        $actual->add('autodílna');

        $expectedException = new Exception('Can\'t add to begin, use add()');
        $this->expectExceptionObject($expectedException);

        $actual->unshift('autodoprava');

        self::assertTrue(true);
    }
    
    /**
     * Test adding a int value to the beginning of a string list
     *
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function tesUnShiftInvalidTypeValueInStringList(): void
    {
        $actual = new StringLinkedList();
        $actual->add('auto');
        $actual->add('autíčko');

        $message =
            'LinkedList\StringLinkedList::unshift(): ' . 
            'Argument #1 ($value) must be of type string, int given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\StringLinkedList\UnshiftTest.php on line 104';  

        $this->expectErrorMessage($message);    

        /** @phpstan-ignore argument.type */
        $actual->unshift(1);

        self::assertTrue(true);
    }
}