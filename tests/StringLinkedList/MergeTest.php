<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

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
        $linkedList1 = new StringLinkedList();
        $linkedList2 = new StringLinkedList();

        self::assertEquals($linkedList2, $linkedList1->merge($linkedList2));
        self::assertSame(0, $linkedList1->merge($linkedList2)->getCount());
        self::assertSame('StringLinkedList number of nodes: 0', $linkedList2->__toString());
    }

    /**
     * Test for first list empty
     *
     * @return void
     */
    public function testFirstLinkedListIsEmpty(): void
    {
        $linkedList1 = new StringLinkedList();

        $linkedList2 = new StringLinkedList();
        $linkedList2->add('b');
        $linkedList2->add('a');
        $linkedList2->add('c');

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList2, $mergedList);

        self::assertSame(
            'StringLinkedList number of nodes: 3' . PHP_EOL .
            'a (prev: null, next: b)' . PHP_EOL .
            'b (prev: a, next: c)' . PHP_EOL .
            'c (prev: b, next: null)',
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
        $linkedList1 = new StringLinkedList();
        $linkedList1->add('b');
        $linkedList1->add('a');
        $linkedList1->add('c');

        $linkedList2 = new StringLinkedList();

        $mergedList = $linkedList1->merge($linkedList2);

        self::assertEquals($linkedList1, $mergedList);

        self::assertSame(
            'StringLinkedList number of nodes: 3' . PHP_EOL .
            'a (prev: null, next: b)' . PHP_EOL .
            'b (prev: a, next: c)' . PHP_EOL .
            'c (prev: b, next: null)',
            $mergedList->__toString()
        );
    }
    
    /**
     * Test merging string lists
     *
     * @return void
     */
    public function testMergeTwoStringLists(): void
    {
        $linkedList1 = new StringLinkedList();
        $linkedList1->add('kočka');
        $linkedList1->add('kocour');
        $linkedList1->add('kočička');
        $linkedList1->add('kočí');

        $linkedList2 = new StringLinkedList();
        $linkedList2->add('kačka');
        $linkedList2->add('Katka');
        $linkedList2->add('kodér');
        $linkedList2->add('kočičí');
        $linkedList2->add('koza');
        $linkedList2->add('kočkodan');
        $linkedList2->add('kočka');

        $expected = new StringLinkedList();
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

        self::assertSame(
            'StringLinkedList number of nodes: 11' . PHP_EOL .
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
            'called in C:\xampp\htdocs\LinkedList\tests\StringLinkedList\MergeTest.php on line 164';

        $this->expectErrorMessage($message);    

        /** @phpstan-ignore argument.type */
        $list1->merge($list2);

        self::assertTrue(true);
    }
}