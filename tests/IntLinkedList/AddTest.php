<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use LinkedList\IntLinkedList;
use PHPUnit\Framework\TestCase;

/**
 * A class for testing the add() method using PHPUnit tests
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class AddTest extends TestCase
{
    /**
     * Add values into int sorted linked list
     *
     * @return void
     */
    public function testAddValuesIntoIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(5);
        $actual->add(3);
        $actual->add(1);
        $actual->add(4);
        $actual->add(8);
        $actual->add(6);

        $expected = new IntLinkedList();
        $expected->add(1);
        $expected->add(3);
        $expected->add(4);
        $expected->add(5);
        $expected->add(6);
        $expected->add(8); 

        self::assertEquals($expected, $actual);
        self::assertSame(
            'IntLinkedList number of nodes: 6' . PHP_EOL .
            '1 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 1, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 6)' . PHP_EOL .
            '6 (prev: 5, next: 8)' . PHP_EOL .
            '8 (prev: 6, next: null)', 
            $actual->__toString()
        );
    }

    /**
     * Add duplicate values into sorted linked list
     *
     * @return void
     */
    public function testAddDuplicateValueIntoIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(5);
        $actual->add(1);
        $actual->add(5);
        $actual->add(3);
        $actual->add(1);
        $actual->add(4);
        $actual->add(2);
        $actual->add(3);

        $expected = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(
            'IntLinkedList number of nodes: 8' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }
    
    /**
     * Add string value into int sorted linked list
     *
     * @return void
     */
    public function testAddStringValueIntoIntList(): void
    {
        $actual = new IntLinkedList();
        $actual->add(3);

        $message = 
         'LinkedList\IntLinkedList::add(): ' . 
         'Argument #1 ($value) must be of type int, string given, ' . 
         'called in C:\xampp\htdocs\LinkedList\tests\IntLinkedList\AddTest.php on line 111';

        $this->expectErrorMessage($message);

        /** @phpstan-ignore argument.type */
        $actual->add('error');

        $this->assertSame('3', $actual->__toString());
    }
}