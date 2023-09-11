<?php declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\LinkedList;

class SearchTest extends TestCase
{
    public function testSearchInEmptyList(): void
    {
        $actual = new LinkedList();
        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }

    public function testSearchStringValueInIntLinkedList(): void
    {
        $value = 'abc';

        $linkedList = new LinkedList();
        $linkedList->add(1);

        $expectedException = new InvalidValueNodeTypeException();
        $this->expectExceptionObject($expectedException);

        $linkedList->search($value);

        self::expectNotToPerformAssertions();
    }

    public function testSearchIntValueInStringLinkedList(): void
    {
        $value = 1;

        $linkedList = new LinkedList("string");
        $linkedList->add('bla bla bla');

        $expectedException = new InvalidValueNodeTypeException("string");
        $this->expectExceptionObject($expectedException);

        $linkedList->search($value);

        self::expectNotToPerformAssertions();
    }

    public function testSingleValueIsInList(): void
    {
        $value = 3;
        $expected = [];

        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }

        $current = $actual->getFirst();
        for ($i = 1; $i <= $value; $i++) {
            /** $current nemůže být null, ale PHPStan to nevidí */
            if ($current?->getValue() === $value) {
                $expected[] = clone($current);
            }

            $current = $current?->getNext();
        }

        self::assertEquals(
            $expected,
            $actual->search($value)
        );
    }

    public function testMultipleValuesIsInList(): void
    {
        $value = 3;
        $expected = [];

        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $current = $actual->getFirst();
        for ($i = 1; $i <= 7; $i++) {
            /** $current nemůže být null, ale PHPStan to nevidí */
            if ($current?->getValue() === $value) {
                $expected[] = clone($current);
            }

            // null být nemůže, ale PHPStan to nevidí
            $current = $current?->getNext();
        }

        self::assertEquals(
            $expected,
            $actual->search($value)
        );
    }

    public function testValueIsNotInList(): void
    {
        $value = 7;

        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }
}