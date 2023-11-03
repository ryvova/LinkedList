<?php declare(strict_types = 1);

namespace LinkedList\Tests\StringLinkedList;

use Exception;
use LinkedList\StringLinkedList;
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
        $actual = new StringLinkedList();

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
        $actual = new StringLinkedList();
        $actual->add('a');

        $actual->shift();

        self::assertSame(
            'StringLinkedList number of nodes: 0', 
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
        $actual = new StringLinkedList();
        $actual->add('b');
        $actual->add('a');

        $actual->shift();

        self::assertSame(
            'StringLinkedList number of nodes: 1' . PHP_EOL . 
            'b (prev: null, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('b');
        $actual->add('c');
        $actual->add('a');

        $actual->shift();

        self::assertSame(
            'StringLinkedList number of nodes: 2' . PHP_EOL . 
            'b (prev: null, next: c)' . PHP_EOL . 
            'c (prev: b, next: null)',
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
        $actual = new StringLinkedList();
        $actual->add('b');
        $actual->add('c');
        $actual->add('a');
        $actual->add('e');
        $actual->add('d');

        $actual->shift();

        self::assertSame(
            'StringLinkedList number of nodes: 4' . PHP_EOL . 
            'b (prev: null, next: c)' . PHP_EOL . 
            'c (prev: b, next: d)' . PHP_EOL . 
            'd (prev: c, next: e)' . PHP_EOL . 
            'e (prev: d, next: null)',
            $actual->__toString()
        );
    }
}