<?php declare(strict_types = 1);

namespace LinkedList\Tests\IntLinkedList;

use Exception;
use LinkedList\IntLinkedList;
use PHPUnit\Framework\TestCase;

class ShiftTest extends TestCase
{
    /**
     * Test remove first node from empty list
     *
     * @return void
     */
    public function testShiftFromEmptyList(): void
    {
        $actual = new IntLinkedList();

        $expectedException = new Exception('Cannot delete from an empty list');
        $this->expectExceptionObject($expectedException);

        $actual->shift();

        $this->addToAssertionCount(1);
    }

    /** 
     * Test remove first node from list which contains one node
     */
    public function testShiftFromListWhichContainsOneNode(): void
    {
        $actual = new IntLinkedList();
        $actual->add(1);

        $actual->shift();

        self::assertSame(
            'IntLinkedList number of nodes: 0', 
            $actual->__toString()
        );
    }

    /**
     * Test remove first node from list which contains two nodes
     *
     * @return void
     */
    public function testShiftFromListWhichContainsTwoNodes(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(1);

        $actual->shift();

        self::assertSame(
            'IntLinkedList number of nodes: 1' . PHP_EOL . 
            '2 (prev: null, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test remove first node from list which contains three nodes
     *
     * @return void
     */
    public function testShiftFromListWhichContainsThreeNodes(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(3);
        $actual->add(1);

        $actual->shift();

        self::assertSame(
            'IntLinkedList number of nodes: 2' . PHP_EOL . 
            '2 (prev: null, next: 3)' . PHP_EOL . 
            '3 (prev: 2, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test remove first node from list which contains more than three nodes
     *
     * @return void
     */
    public function testShiftFromListWhichContainsMoreThanThreeNodes(): void
    {
        $actual = new IntLinkedList();
        $actual->add(2);
        $actual->add(3);
        $actual->add(1);
        $actual->add(5);
        $actual->add(4);

        $actual->shift();

        self::assertSame(
            'IntLinkedList number of nodes: 4' . PHP_EOL . 
            '2 (prev: null, next: 3)' . PHP_EOL . 
            '3 (prev: 2, next: 4)' . PHP_EOL . 
            '4 (prev: 3, next: 5)' . PHP_EOL . 
            '5 (prev: 4, next: null)',
            $actual->__toString()
        );
    }
}