<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\StringLinkedList;
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
        $actual = new StringLinkedList();
        $value = 1;

        $message = 
            'LinkedList\StringLinkedList::search(): ' . 
            'Argument #1 ($value) must be of type string, int given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\StringLinkedList\SearchTest.php on line 38';

        $this->expectErrorMessage($message);

        /** @phpstan-ignore argument.type */
        $actual->search($value);

        self::expectNotToPerformAssertions();
    }

    /**
     * Test search int value in string list
     *
     * @return void
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function testSearchIntValueInStringLinkedList(): void
    {
        $value = 1;

        $linkedList = new StringLinkedList();
        $linkedList->add('bla bla bla');

        $message = 
            'LinkedList\StringLinkedList::search(): ' . 
            'Argument #1 ($value) must be of type string, int given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\StringLinkedList\SearchTest.php on line 65';

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
        $value = 'b';
        $expected = [];

        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');

        $first = $actual->getFirst();
        /** @var Node $first */
        $second = $first->getNext();
        /** @var Node $second */
        $expected[] = clone($second);
    
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
        $value = 'c';
        $expected = [];

        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('c');
        $actual->add('d');
        $actual->add('e');
        $actual->add('e');
        
        $first = $actual->getFirst();
        /** @var Node $first */
        $second = $first->getNext();
        /** @var Node $second */
        $third = $second->getNext();
        /** @var Node $third */
        $fourth = $third->getNext();
        $current = $fourth; 
        /** @var Node $fourth */
        $fifth = $fourth->getNext();
        /** @var Node $current->getNext() */
        /** @var Node $fifth */
        $expected =
            [
                clone($current),
                clone($fifth)
            ];
        

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
        $value = 'f';

        $actual = new StringLinkedList();
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }
}