<?php declare(strict_types = 1);

namespace LinkedList\Tests\LinkedList;

use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\LinkedList;
use PHPUnit\Framework\TestCase;

/**
 * Třída pro vyhledávání v seznamu
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class SearchTest extends TestCase
{
    /**
     * Test vyhledávání v prázdném seznamu
     *
     * @return void
     */
    public function testSearchInEmptyList(): void
    {
        $actual = new LinkedList();
        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->search($value);

        self::expectNotToPerformAssertions();
    }

    /**
     * Test vyhledávání string hodnoty v int seznamu
     *
     * @return void
     */
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

    /**
     * Test vyhledávání int hodnoty ve string seznamu
     *
     * @return void
     */
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

    /**
     * Test vyhledávání vyhledávání hodnoty v seznamu, kde se každá hodnota vyskytuje jen 1x
     *
     * @return void
     */
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

    /**
     * Test vyhledávání hodnoty, která se v seznamu vyskytuje vícekrát
     *
     * @return void
     */
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

    /**
     * Test vyhledávání hodnoty, která není v seznamu
     *
     * @return void
     */
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