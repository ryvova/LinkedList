<?php declare(strict_types = 1);

namespace LinkedList\Tests\LinkedList;

use Exception;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\LinkedList;
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
        $actual = new LinkedList();
        $actual->unshift(1);

        self::assertSame(
            'LinkedList number of nodes: 1, values type: int' . PHP_EOL .
            '1 (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test adding a value to the beginning of a int list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftIntoIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(2);
        $actual->add(3);
        $actual->unshift(1);

        self::assertSame(
            'LinkedList number of nodes: 3, values type: int' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test adding a value to the beginning of a string list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testUnshiftIntoStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('dláto');
        $actual->add('dlažba');
        $actual->unshift('čepice');

        self::assertSame(
            'LinkedList number of nodes: 3, values type: string' . PHP_EOL .
            'čepice (prev: null, next: dláto)' . PHP_EOL .
            'dláto (prev: čepice, next: dlažba)' . PHP_EOL .
            'dlažba (prev: dláto, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test adding a big value to the beginning of a int list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testInsertBigValueToIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(2);
        $actual->add(3);

        $expectedException = new Exception('Can\'t add to begin, use add()');
        $this->expectExceptionObject($expectedException);

        $actual->unshift(4);

        self::assertTrue(true);
    }

    /**
     * Test adding a big value to the beginning of a string list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testInsertBigValueToStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('auto');
        $actual->add('autodílna');

        $expectedException = new Exception('Can\'t add to begin, use add()');
        $this->expectExceptionObject($expectedException);

        $actual->unshift('autodoprava');

        self::assertTrue(true);
    }

    /**
     * Test adding a string value to the beginning of a int list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testShiftInvalidTypeValueInIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(2);
        $actual->add(3);

        $expectedException = new InvalidValueNodeTypeException('int');
        $this->expectExceptionObject($expectedException);

        $actual->unshift('bota');

        self::assertTrue(true);
    }

    /**
     * Test adding a int value to the beginning of a string list
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException node value type not equals list nodes type
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function testShiftInvalidTypeValueInStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('auto');
        $actual->add('autíčko');

        $expectedException = new InvalidValueNodeTypeException('string');
        $this->expectExceptionObject($expectedException);

        $actual->unshift(1);

        self::assertTrue(true);
    }
}