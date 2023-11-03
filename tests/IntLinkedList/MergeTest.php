<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use LinkedList\IntLinkedList;
use LinkedList\StringLinkedList;
use PHPUnit\Framework\TestCase;

/**
 * A class for testing the union of two lists
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class MergeTest extends TestCase
{
    /**
     * Test for both empty lists
     *
     * @return void
     */
    public function testBothLinkedListsAreEmpty(): void
    {
        $linkedList1 = new IntLinkedList();
        $linkedList2 = new IntLinkedList();

        self::assertEquals($linkedList2, $linkedList1->merge($linkedList2));
        self::assertSame(0, $linkedList1->merge($linkedList2)->getCount());
        self::assertSame('IntLinkedList number of nodes: 0', $linkedList2->__toString());
    }

    /**
     * Test for first list empty
     *
     * @return void
     */
    public function testFirstLinkedListIsEmpty(): void
    {
        $linkedList1 = new IntLinkedList();

        $linkedList2 = new IntLinkedList();
        $linkedList2->add(2);
        $linkedList2->add(1);
        $linkedList2->add(3);

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList2, $mergedList);
        self::assertSame(3, $mergedList->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 3' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: null)',
            $mergedList->__toString()
        );
    }

    /**
     * Test for the second list empty
     *
     * @return void
     */
    public function testSecondLinkedListIsEmpty(): void
    {
        $linkedList1 = new IntLinkedList();
        $linkedList1->add(2);
        $linkedList1->add(1);
        $linkedList1->add(3);

        $linkedList2 = new IntLinkedList();

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList1, $mergedList);
        self::assertSame(3, $mergedList->getCount());

        self::assertSame(
            'IntLinkedList number of nodes: 3' . PHP_EOL .
            '1 (prev: null, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: null)',
            $mergedList->__toString()
        );
    }

    /**
     * Test merging int lists
     *
     * @return void
     */
    public function testMergeToIntLists(): void
    {
        $linkedList1 = new IntLinkedList();
        $linkedList1->add(3);
        $linkedList1->add(5);
        $linkedList1->add(6);
        $linkedList1->add(10);
        $linkedList1->add(12);

        $linkedList2 = new IntLinkedList();
        $linkedList2->add(1);
        $linkedList2->add(3);
        $linkedList2->add(4);
        $linkedList2->add(6);
        $linkedList2->add(7);
        $linkedList2->add(11);
        $linkedList2->add(13);
        $linkedList2->add(14);

        self::assertSame(
            'IntLinkedList number of nodes: 13' . PHP_EOL .
            '1 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 6)' . PHP_EOL .
            '6 (prev: 5, next: 6)' . PHP_EOL .
            '6 (prev: 6, next: 7)' . PHP_EOL .
            '7 (prev: 6, next: 10)' . PHP_EOL .
            '10 (prev: 7, next: 11)' . PHP_EOL .
            '11 (prev: 10, next: 12)' . PHP_EOL .
            '12 (prev: 11, next: 13)' . PHP_EOL .
            '13 (prev: 12, next: 14)' . PHP_EOL .
            '14 (prev: 13, next: null)',
            $linkedList1->merge($linkedList2)->__toString()
        );
    }
    
    /**
     * Test merging string list into int list
     *
     * @return void
     */
    public function testMergeStringListIntoIntList(): void
    {
        $list1 = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $list1->add($i);
        }

        $list2 = new StringLinkedList();
        $list2->add('a');

        $message =
            'LinkedList\IntLinkedList::merge(): ' . 
            'Argument #1 ($intLinkedList) must be of type LinkedList\IntLinkedList, LinkedList\StringLinkedList given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\IntLinkedList\MergeTest.php on line 154';

        $this->expectErrorMessage($message);

        /** @phpstan-ignore argument.type */
        $list1->merge($list2);

        self::assertTrue(true);
    }

    /**
     * Test merging int list into string list
     *
     * @return void
     */
    public function testMergeIntListIntoStringList(): void
    {
        $list1 = new StringLinkedList();
        $list1->add('auto');
        $list1->add('bota');

        $list2 = new IntLinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $list2->add($i);
        }

        $message = 
            'LinkedList\StringLinkedList::merge(): ' . 
            'Argument #1 ($stringLinkedList) must be of type LinkedList\StringLinkedList, LinkedList\IntLinkedList given, ' . 
            'called in C:\xampp\htdocs\LinkedList\tests\IntLinkedList\MergeTest.php on line 183';

        $this->expectErrorMessage($message);

        /** @phpstan-ignore argument.type */
        $list1->merge($list2);

        self::assertTrue(true);
    }
}