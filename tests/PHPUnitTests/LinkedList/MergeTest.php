<?php declare(strict_types = 1);

namespace LinkedList\Tests\LinkedList;

use LinkedList\Exceptions\InvalidListTypeException;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\LinkedList;
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
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     */
    public function testBothLinkedListsAreEmpty(): void
    {
        $linkedList1 = new LinkedList();
        $linkedList2 = new LinkedList();

        self::assertEquals($linkedList2, $linkedList1->merge($linkedList2));
        self::assertSame(0, $linkedList1->merge($linkedList2)->getCount());
        self::assertSame('LinkedList number of nodes: 0, values type: int', $linkedList2->__toString());
    }

    /**
     * Test for first list empty
     *
     * @return void
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testFirstLinkedListIsEmpty(): void
    {
        $linkedList1 = new LinkedList();

        $linkedList2 = new LinkedList();
        $linkedList2->add(2);
        $linkedList2->add(1);
        $linkedList2->add(3);

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList2, $mergedList);
        self::assertSame(3, $mergedList->getCount());

        self::assertSame(
            'LinkedList number of nodes: 3, values type: int' . PHP_EOL .
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
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testSecondLinkedListIsEmpty(): void
    {
        $linkedList1 = new LinkedList();
        $linkedList1->add(2);
        $linkedList1->add(1);
        $linkedList1->add(3);

        $linkedList2 = new LinkedList();

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList1, $mergedList);
        self::assertSame(3, $mergedList->getCount());

        self::assertSame(
            'LinkedList number of nodes: 3, values type: int' . PHP_EOL .
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
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testMergeToIntLists(): void
    {
        $linkedList1 = new LinkedList();
        $linkedList1->add(3);
        $linkedList1->add(5);
        $linkedList1->add(6);
        $linkedList1->add(10);
        $linkedList1->add(12);

        $linkedList2 = new LinkedList();
        $linkedList2->add(1);
        $linkedList2->add(3);
        $linkedList2->add(4);
        $linkedList2->add(6);
        $linkedList2->add(7);
        $linkedList2->add(11);
        $linkedList2->add(13);
        $linkedList2->add(14);

        self::assertSame(
            'LinkedList number of nodes: 13, values type: int' . PHP_EOL .
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
     * Test merging string lists
     *
     * @return void
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testMergeToStingLists(): void
    {
        $linkedList1 = new LinkedList('string');
        $linkedList1->add('kočka');
        $linkedList1->add('kocour');
        $linkedList1->add('kočička');
        $linkedList1->add('kočí');

        $linkedList2 = new LinkedList('string');
        $linkedList2->add('kačka');
        $linkedList2->add('Katka');
        $linkedList2->add('kodér');
        $linkedList2->add('kočičí');
        $linkedList2->add('koza');
        $linkedList2->add('kočkodan');
        $linkedList2->add('kočka');

        $expected = new LinkedList('string');
        $expected->add('kočka');
        $expected->add('kocour');
        $expected->add('kočička');
        $expected->add('kočí');
        $expected->add('kačka');
        $expected->add('Katka');
        $expected->add('kodér');
        $expected->add('kočičí');
        $expected->add('koza');
        $expected->add('kočkodan');
        $expected->add('kočka');

        $mergedLinkedlist = $linkedList1->merge($linkedList2);

        self::assertSame(11, $mergedLinkedlist->getCount());

        self::assertSame(
            'LinkedList number of nodes: 11, values type: string' . PHP_EOL .
                    'kačka (prev: null, next: Katka)' . PHP_EOL .
                    'Katka (prev: kačka, next: kocour)' . PHP_EOL .
                    'kocour (prev: Katka, next: kočí)' . PHP_EOL .
                    'kočí (prev: kocour, next: kočičí)' . PHP_EOL .
                    'kočičí (prev: kočí, next: kočička)' . PHP_EOL .
                    'kočička (prev: kočičí, next: kočka)' . PHP_EOL .
                    'kočka (prev: kočička, next: kočka)' . PHP_EOL .
                    'kočka (prev: kočka, next: kočkodan)' . PHP_EOL .
                    'kočkodan (prev: kočka, next: kodér)' . PHP_EOL .
                    'kodér (prev: kočkodan, next: koza)' . PHP_EOL .
                    'koza (prev: kodér, next: null)',
            $mergedLinkedlist->__toString()
        );
    }

    /**
     * Test merging string list into int list
     *
     * @return void
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testMergeStringListIntoIntList(): void
    {
        $list1 = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $list1->add($i);
        }

        $list2 = new LinkedList("string");
        $list2->add('a');

        $expectedException = new InvalidListTypeException();
        $this->expectExceptionObject($expectedException);

        $list1->merge($list2);

        self::assertTrue(true);
    }

    /**
     * Test merging int list into string list
     *
     * @return void
     *
     * @throws InvalidListTypeException      lists do not have the same value type
     * @throws InvalidValueNodeTypeException bad node value type
     */
    public function testMergeIntListIntoStringList(): void
    {
        $list1 = new LinkedList('string');
        $list1->add('auto');
        $list1->add('bota');

        $list2 = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $list2->add($i);
        }

        $expectedException = new InvalidListTypeException();
        $this->expectExceptionObject($expectedException);

        $list1->merge($list2);

        self::assertTrue(true);
    }
}