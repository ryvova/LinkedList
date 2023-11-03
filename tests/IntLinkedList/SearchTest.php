<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\IntLinkedList;
use LinkedList\Node;
use PHPUnit\Framework\TestCase;

/**
 * A class for searching in a list
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class SearchTest extends TestCase
{
    /**
     * Test search in empty list
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testSearchInEmptyList(): void
    {
        $actual = new IntLinkedList();
        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }

    /**
     * test search string value in int list
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testSearchStringValueInIntLinkedList(): void
    {
        $value = 'abc';

        $linkedList = new IntLinkedList();
        $linkedList->add(1);

        $message = 
            'LinkedList\IntLinkedList::search(): ' . 
            'Argument #1 ($value) must be of type int, string given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\IntLinkedList\SearchTest.php on line 60';
 
        $this->expectErrorMessage($message);

        /** @phpstan-ignore argument.type */
        $linkedList->search($value);

        self::expectNotToPerformAssertions();
    }
    
    /**
     * The search test searches for a value in a list where each value occurs only 1 time
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testSingleValueIsInList(): void
    {
        $value = 3;
        $expected = [];

        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }

        $current = $actual->getFirst();
        for ($i = 1; $i <= $value; $i++) {
            /** @var Node $current */
            if ($current->getValue() === $value) {
                $expected[] = clone($current);
            }

            $current = $current->getNext();
        }

        self::assertEquals(
            $expected,
            $actual->search($value)
        );
    }

    /**
     * Test to find a value that occurs more than once in a list
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testMultipleValuesIsInList(): void
    {
        $value = 3;
        $expected = [];

        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $current = $actual->getFirst();
        for ($i = 1; $i <= 7; $i++) {
            /** @var Node $current */
            if ($current->getValue() === $value) {
                $expected[] = clone($current);
            }

            $current = $current->getNext();
        }

        self::assertEquals(
            $expected,
            $actual->search($value)
        );
    }

    /**
     * Test vyhledávání hodnoty, která není v seznamu
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testValueIsNotInList(): void
    {
        $value = 7;

        $actual = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }
}