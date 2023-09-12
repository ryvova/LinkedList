<?php declare(strict_types = 1);

namespace LinkedList\Tests;

use PHPUnit\Framework\TestCase;
use LinkedList\LinkedList;

/**
 * Třída pro otestování metody __toString() pomocí PHPUnit testů
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class ToStringTest extends TestCase
{
    /**
     * Test vyhledávání v prázdném seznamu
     *
     * @return void
     */
    public function testEmptyList(): void
    {
        $list = new LinkedList();

        self::assertSame('LinkedList počet prvků: 0, typ hodnot: int', $list->__toString());
    }

    /**
     * Test vyhledávání v seznamu obsahujícím jen 1 node
     *
     * @return void
     */
    public function testListWithOneNode(): void
    {
        $actual = new LinkedList();
        $actual->add(7);

        self::assertSame(
            'LinkedList počet prvků: 1, typ hodnot: int' . PHP_EOL .
            '7 (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test vyhledávání v seznamu obsahujícím 2 node
     *
     * @return void
     */
    public function testListWithTwoNode(): void
    {
        $actual = new LinkedList();
        $actual->add(2);
        $actual->add(1);

        self::assertSame(
            'LinkedList počet prvků: 2, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test vyhledávání v seznamu obsahujícím více než 2 node
     *
     * @return void
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
            'LinkedList počet prvků: 5, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: null)',
            $actual->__toString()
        );
    }
}