<?php declare(strict_types = 1);

namespace LinkedList\Tests\LinkedList;

use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\LinkedList;
use PHPUnit\Framework\TestCase;

/**
 * Třída pro otestování metody add() pomocí PHPUnit testů
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class AddTest extends TestCase
{
    /**
     * Test přidání hodnoty do int seznamu
     *
     * @return void
     */
    public function testAddValuesIntoIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(5);
        $actual->add(3);
        $actual->add(1);
        $actual->add(4);
        $actual->add(8);
        $actual->add(6);

        $expected = new LinkedList();
        $expected->add(1);
        $expected->add(3);
        $expected->add(4);
        $expected->add(5);
        $expected->add(6);
        $expected->add(8);

        self::assertSame(
            'LinkedList počet prvků: 6, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 3)' . PHP_EOL .
            '3 (prev: 1, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 6)' . PHP_EOL .
            '6 (prev: 5, next: 8)' . PHP_EOL .
            '8 (prev: 6, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test přidání duplicitní hodnoty do int seznamu
     *
     * @return void
     */
    public function testAddDuplicateValueIntoIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(5);
        $actual->add(1);
        $actual->add(5);
        $actual->add(3);
        $actual->add(1);
        $actual->add(4);
        $actual->add(2);
        $actual->add(3);

        $expected = new LinkedList();
        for ($i = 1; $i <= 5; $i++) {
            $expected->add($i);

            if ($i % 2 === 1) {
                $expected->add($i);
            }
        }

        self::assertEquals($expected, $actual);
        self::assertSame(
            'LinkedList počet prvků: 8, typ hodnot: int' . PHP_EOL .
            '1 (prev: null, next: 1)' . PHP_EOL .
            '1 (prev: 1, next: 2)' . PHP_EOL .
            '2 (prev: 1, next: 3)' . PHP_EOL .
            '3 (prev: 2, next: 3)' . PHP_EOL .
            '3 (prev: 3, next: 4)' . PHP_EOL .
            '4 (prev: 3, next: 5)' . PHP_EOL .
            '5 (prev: 4, next: 5)' . PHP_EOL .
            '5 (prev: 5, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test přidání hodnoty do string seznamu
     *
     * @return void
     */
    public function testAddValuesIntoStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('a');
        $actual->add('b');
        $actual->add('c');
        $actual->add('č');
        $actual->add('d');
        $actual->add('ď');
        $actual->add('e');
        $actual->add('é');
        $actual->add('ě');
        $actual->add('f');
        $actual->add('g');
        $actual->add('h');
        $actual->add('ch');
        $actual->add('i');
        $actual->add('í');
        $actual->add('j');
        $actual->add('k');
        $actual->add('l');
        $actual->add('m');
        $actual->add('n');
        $actual->add('ň');
        $actual->add('o');
        $actual->add('ó');
        $actual->add('p');
        $actual->add('q');
        $actual->add('r');
        $actual->add('ř');
        $actual->add('s');
        $actual->add('š');
        $actual->add('t');
        $actual->add('ť');
        $actual->add('u');
        $actual->add('ú');
        $actual->add('ů');
        $actual->add('v');
        $actual->add('w');
        $actual->add('x');
        $actual->add('y');
        $actual->add('ý');
        $actual->add('z');
        $actual->add('ž');
        $actual->add('A');
        $actual->add('B');
        $actual->add('C');
        $actual->add('Č');
        $actual->add('D');
        $actual->add('Ď');
        $actual->add('E');
        $actual->add('É');
        $actual->add('Ě');
        $actual->add('F');
        $actual->add('G');
        $actual->add('H');
        $actual->add('CH');
        $actual->add('I');
        $actual->add('Í');
        $actual->add('J');
        $actual->add('K');
        $actual->add('L');
        $actual->add('M');
        $actual->add('N');
        $actual->add('Ň');
        $actual->add('O');
        $actual->add('Ó');
        $actual->add('P');
        $actual->add('Praha 1');
        $actual->add('Praha 10');
        $actual->add('Praha 3');
        $actual->add('Q');
        $actual->add('R');
        $actual->add('Ř');
        $actual->add('S');
        $actual->add('Š');
        $actual->add('T');
        $actual->add('Ť');
        $actual->add('U');
        $actual->add('Ú');
        $actual->add('Ů');
        $actual->add('V');
        $actual->add('W');
        $actual->add('X');
        $actual->add('Y');
        $actual->add('Ý');
        $actual->add('Z');
        $actual->add('Ž');

        $expected = new LinkedList('string');
        $expected->add('a');
        $expected->add('b');
        $expected->add('c');
        $expected->add('č');
        $expected->add('d');
        $expected->add('ď');
        $expected->add('e');
        $expected->add('é');
        $expected->add('ě');
        $expected->add('f');
        $expected->add('g');
        $expected->add('h');
        $expected->add('ch');
        $expected->add('i');
        $expected->add('í');
        $expected->add('j');
        $expected->add('k');
        $expected->add('l');
        $expected->add('m');
        $expected->add('n');
        $expected->add('ň');
        $expected->add('o');
        $expected->add('ó');
        $expected->add('p');
        $expected->add('q');
        $expected->add('r');
        $expected->add('ř');
        $expected->add('s');
        $expected->add('š');
        $expected->add('t');
        $expected->add('ť');
        $expected->add('u');
        $expected->add('ú');
        $expected->add('ů');
        $expected->add('v');
        $expected->add('w');
        $expected->add('x');
        $expected->add('y');
        $expected->add('ý');
        $expected->add('z');
        $expected->add('ž');
        $expected->add('A');
        $expected->add('B');
        $expected->add('C');
        $expected->add('Č');
        $expected->add('D');
        $expected->add('Ď');
        $expected->add('E');
        $expected->add('É');
        $expected->add('Ě');
        $expected->add('F');
        $expected->add('G');
        $expected->add('H');
        $expected->add('CH');
        $expected->add('I');
        $expected->add('Í');
        $expected->add('J');
        $expected->add('K');
        $expected->add('L');
        $expected->add('M');
        $expected->add('N');
        $expected->add('Ň');
        $expected->add('O');
        $expected->add('Ó');
        $expected->add('P');
        $expected->add('Praha 1');
        $expected->add('Praha 3');
        $expected->add('Praha 10');
        $expected->add('Q');
        $expected->add('R');
        $expected->add('Ř');
        $expected->add('S');
        $expected->add('Š');
        $expected->add('T');
        $expected->add('Ť');
        $expected->add('U');
        $expected->add('Ú');
        $expected->add('Ů');
        $expected->add('V');
        $expected->add('W');
        $expected->add('X');
        $expected->add('Y');
        $expected->add('Ý');
        $expected->add('Z');
        $expected->add('Ž');

        self::assertEquals($expected, $actual);

        self::assertSame(
            'LinkedList počet prvků: 85, typ hodnot: string' . PHP_EOL .
            'a (prev: null, next: A)' . PHP_EOL .
            'A (prev: a, next: b)' . PHP_EOL .
            'b (prev: A, next: B)' . PHP_EOL .
            'B (prev: b, next: c)' . PHP_EOL .
            'c (prev: B, next: C)' . PHP_EOL .
            'C (prev: c, next: č)' . PHP_EOL .
            'č (prev: C, next: Č)' . PHP_EOL .
            'Č (prev: č, next: d)' . PHP_EOL .
            'd (prev: Č, next: D)' . PHP_EOL .
            'D (prev: d, next: ď)' . PHP_EOL .
            'ď (prev: D, next: Ď)' . PHP_EOL .
            'Ď (prev: ď, next: e)' . PHP_EOL .
            'e (prev: Ď, next: E)' . PHP_EOL .
            'E (prev: e, next: é)' . PHP_EOL .
            'é (prev: E, next: É)' . PHP_EOL .
            'É (prev: é, next: ě)' . PHP_EOL .
            'ě (prev: É, next: Ě)' . PHP_EOL .
            'Ě (prev: ě, next: f)' . PHP_EOL .
            'f (prev: Ě, next: F)' . PHP_EOL .
            'F (prev: f, next: g)' . PHP_EOL .
            'g (prev: F, next: G)' . PHP_EOL .
            'G (prev: g, next: h)' . PHP_EOL .
            'h (prev: G, next: H)' . PHP_EOL .
            'H (prev: h, next: ch)' . PHP_EOL .
            'ch (prev: H, next: CH)' . PHP_EOL .
            'CH (prev: ch, next: i)' . PHP_EOL .
            'i (prev: CH, next: I)' . PHP_EOL .
            'I (prev: i, next: í)' . PHP_EOL .
            'í (prev: I, next: Í)' . PHP_EOL .
            'Í (prev: í, next: j)' . PHP_EOL .
            'j (prev: Í, next: J)' . PHP_EOL .
            'J (prev: j, next: k)' . PHP_EOL .
            'k (prev: J, next: K)' . PHP_EOL .
            'K (prev: k, next: l)' . PHP_EOL .
            'l (prev: K, next: L)' . PHP_EOL .
            'L (prev: l, next: m)' . PHP_EOL .
            'm (prev: L, next: M)' . PHP_EOL .
            'M (prev: m, next: n)' . PHP_EOL .
            'n (prev: M, next: N)' . PHP_EOL .
            'N (prev: n, next: ň)' . PHP_EOL .
            'ň (prev: N, next: Ň)' . PHP_EOL .
            'Ň (prev: ň, next: o)' . PHP_EOL .
            'o (prev: Ň, next: O)' . PHP_EOL .
            'O (prev: o, next: ó)' . PHP_EOL .
            'ó (prev: O, next: Ó)' . PHP_EOL .
            'Ó (prev: ó, next: p)' . PHP_EOL .
            'p (prev: Ó, next: P)' . PHP_EOL .
            'P (prev: p, next: Praha 1)' . PHP_EOL .
            'Praha 1 (prev: P, next: Praha 3)' . PHP_EOL .
            'Praha 3 (prev: Praha 1, next: Praha 10)' . PHP_EOL .
            'Praha 10 (prev: Praha 3, next: q)' . PHP_EOL .
            'q (prev: Praha 10, next: Q)' . PHP_EOL .
            'Q (prev: q, next: r)' . PHP_EOL .
            'r (prev: Q, next: R)' . PHP_EOL .
            'R (prev: r, next: ř)' . PHP_EOL .
            'ř (prev: R, next: Ř)' . PHP_EOL .
            'Ř (prev: ř, next: s)' . PHP_EOL .
            's (prev: Ř, next: S)' . PHP_EOL .
            'S (prev: s, next: š)' . PHP_EOL .
            'š (prev: S, next: Š)' . PHP_EOL .
            'Š (prev: š, next: t)' . PHP_EOL .
            't (prev: Š, next: T)' . PHP_EOL .
            'T (prev: t, next: ť)' . PHP_EOL .
            'ť (prev: T, next: Ť)' . PHP_EOL .
            'Ť (prev: ť, next: u)' . PHP_EOL .
            'u (prev: Ť, next: U)' . PHP_EOL .
            'U (prev: u, next: ú)' . PHP_EOL .
            'ú (prev: U, next: Ú)' . PHP_EOL .
            'Ú (prev: ú, next: ů)' . PHP_EOL .
            'ů (prev: Ú, next: Ů)' . PHP_EOL .
            'Ů (prev: ů, next: v)' . PHP_EOL .
            'v (prev: Ů, next: V)' . PHP_EOL .
            'V (prev: v, next: w)' . PHP_EOL .
            'w (prev: V, next: W)' . PHP_EOL .
            'W (prev: w, next: x)' . PHP_EOL .
            'x (prev: W, next: X)' . PHP_EOL .
            'X (prev: x, next: y)' . PHP_EOL .
            'y (prev: X, next: Y)' . PHP_EOL .
            'Y (prev: y, next: ý)' . PHP_EOL .
            'ý (prev: Y, next: Ý)' . PHP_EOL .
            'Ý (prev: ý, next: z)' . PHP_EOL .
            'z (prev: Ý, next: Z)' . PHP_EOL .
            'Z (prev: z, next: ž)' . PHP_EOL .
            'ž (prev: Z, next: Ž)' . PHP_EOL .
            'Ž (prev: ž, next: null)',
            $actual->__toString()
        );
    }

    /**
     * Test přidání duplicitní hodnoty do string seznamu
     * Kontrolováno podle ČSN pro češtinu, viz https://www.pistorius.cz/img/download/21.pdf
     *
     * @return void
     *
     * @throws InvalidValueNodeTypeException
     */
    public function testAddDuplicateValueIntoStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('bů');
        $actual->add('beďar');
        $actual->add('baroko');
        $actual->add('bedla');
        $actual->add('bál');
        $actual->add('bééé');
        $actual->add('bé');
        $actual->add('bál');

        $expected = new LinkedList('string');
        $expected->add('baroko');
        $expected->add('bál');
        $expected->add('bál');
        $expected->add('bedla');
        $expected->add('beďar');
        $expected->add('bé');
        $expected->add('bééé');
        $expected->add('bů');

        self::assertEquals($expected, $actual);
        self::assertSame(
            'LinkedList počet prvků: 8, typ hodnot: string' . PHP_EOL .
            'bál (prev: null, next: bál)' . PHP_EOL .
            'bál (prev: bál, next: baroko)' . PHP_EOL .
            'baroko (prev: bál, next: bé)' . PHP_EOL .
            'bé (prev: baroko, next: beďar)' . PHP_EOL .
            'beďar (prev: bé, next: bedla)' . PHP_EOL .
            'bedla (prev: beďar, next: bééé)' . PHP_EOL .
            'bééé (prev: bedla, next: bů)' . PHP_EOL .
            'bů (prev: bééé, next: null)',
            $actual->__toString()
        );
    }

    public function addStringValueIntoIntList(): void
    {
        $actual = new LinkedList();
        $actual->add(3);

        $expectedException = new InvalidValueNodeTypeException();
        $this->expectExceptionObject($expectedException);

        $actual->$actual->add('Tohle spadne na InvalidValueNodeTypeException');

        $this->assertSame('3', $actual->__toString());
    }

    public function addIntValueIntoStringList(): void
    {
        $actual = new LinkedList('string');
        $actual->add('bla bla bla');

        $expectedException = new InvalidValueNodeTypeException();
        $this->expectExceptionObject($expectedException);

        $actual->add(1);

        $this->assertSame('bla bla bla', $actual->__toString());
    }
}