<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use LinkedList\Exceptions\NodeNotFoundException;
use LinkedList\LinkedList;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    public function testDeleteFromEmptyList(): void
    {
        $actual = new LinkedList();
        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->delete($value);
        self::assertSame('', $actual->__toString());
        self::assertSame(0, $actual->getCount());
    }

    public function testDeleteValueWhichNotInList(): void
    {
        $actual = new LinkedList();
        $actual->add(2);

        $value = 1;

        $expectedException = new NodeNotFoundException($value);
        $this->expectExceptionObject($expectedException);

        $actual->delete($value);

        self::assertSame('', $actual->__toString());
        self::assertSame(0, $actual->getCount());
    }

    public function testListContainsOneNode(): void
    {
        $value = 3;

        $actual = new LinkedList();
        $actual->add($value);
        $actual->delete($value);

        self::assertEquals(new LinkedList(), $actual);
        self::assertSame(0, $actual->getCount());
        self::assertEquals('LinkedList počet prvků: 0, typ hodnot: int', $actual->__toString());
    }

    public function testAllValuesInListIsSame(): void
    {
        $value = 1;

        $actual = new LinkedList();
        for ($i = 1; $i <= 10; $i++) {
            $actual->add($value);
        }
        $actual->delete($value);

        self::assertEquals(new LinkedList(), $actual);
        self::assertSame(0, $actual->getCount());
        self::assertEquals('LinkedList počet prvků: 0, typ hodnot: int', $actual->__toString());
    }

    public function testDeleteFirstValue(): void
    {
        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);
        }
        $actual->delete(1);

        $expected = new LinkedList();
        for ($i = 2; $i <= 5; $i++) {
            $expected->add($i);
        }

        self::assertEquals($expected, $actual);
        self::assertSame(4, $actual->getCount());

        self::assertSame(
            'LinkedList počet prvků: 4, typ hodnot: int' . PHP_EOL .
            '2 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: null)',
            $actual->__toString()
        );
    }

    public function testDeleteMoreValuesFromBegin(): void
    {
        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(1);

        $expected = new LinkedList();
        for ($i = 2; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'LinkedList počet prvků: 8, typ hodnot: int' . PHP_EOL .
            '2 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }

    public function testDeleteMoreValueFromEnd(): void
    {
        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(5);

        $expected = new LinkedList();
        for ($i = 1; $i <= 4; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'LinkedList počet prvků: 8, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: null)',
            $actual->__toString()
        );
    }

    public function testDeleteFromMiddle(): void
    {
        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(3);

        $expected = new LinkedList();
        for ($i = 1; $i <= 2; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        for ($i = 4; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(8, $actual->getCount());

        self::assertSame(
            'LinkedList počet prvků: 8, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 4)' . PHP_EOL .
            '4 (prev: 2, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }

    public function testDeleteOnlyOneValue(): void
    {
        $actual = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $actual->add($i);

            if ($i % 2 === 1) {
                $actual->add($i);
                $actual->add($i);
            }
        }

        $actual->delete(3, false);

        self::assertSame(
            'LinkedList počet prvků: 10, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }
}