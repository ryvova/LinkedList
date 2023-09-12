<?php declare(strict_types = 1);

namespace LinkedList;

use Collator;
use Exception;
use LinkedList\Exceptions\InvalidListTypeException;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\Exceptions\NodeNotFoundException;

/**
 * Třída pro práci se setříděným spojovým seznamem.
 *
 * Možno zvážit pro vyhledávání prvků vytvoření BST viz např.ht tps://stackoverflow.com/questions/6472885/bst-to-linked-list
 * Aby to mělo smysl, tak by se asi nejdříve musel vytvořit seznam, pak BST a pak teprve vyhledávat, protože jinak by se
 * při každém přidání/odebrání uzlu ze seznamu musel BST aktualizovat.
 */
class LinkedList
{
    /** @var string typ value v Node */
    private string $type = 'int';

    /** @var Node|null první prvek seznamu */
    private ?Node $first = null;

    /** @var Node|null poslední prvek seznamu */
    private ?Node $last = null;

    /** @var non-negative-int počet prvků v seznamu */
    private int $count = 0;

    /**
     * @var Collator pro porovnávání podle diakritiky
     */
    private Collator $collator;

    /**
     * Vytvoří nový seznam
     *
     * @param string $type typ hodnot v seznamu
     *
     * @throws Exception
     */
    public function __construct(string $type = 'int') {
        $this->type = $type;

        // pro třídění dle nastavení systému
        $collator = collator_create(locale_get_default());

        if ($collator === null) {
            throw new Exception('Chyba při vytváření collatoru');
        }

        // aby třídilo Praha 1, Praha 3 a Praha 10 v tomto pořadí
        $collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::ON);

        $this->collator = $collator; 
    }

    public function getFirst(): ?Node
    {
        return $this->first;
    }

    public function setFirst(Node $node): void
    {
        $this->first = $node;
    }

    public function getLast(): ?Node
    {
        return $this->last;
    }

    public function setLast(Node $node): void
    {
        $this->last = $node;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Přidá hodnotu na začátek seznamu
     *
     * @param int|string $value
     * @return void
     * @throws Exception
     */
    public function unshift(int|string $value): void {
        if ($this->first !== null && $this->compare($value, $this->first->getValue()) === 1) {
            throw new Exception("Nelze přidat na začátek, použij add()");
        }

        $node = new Node($value, null, $this->first);

        /** @phpstan-ignore-next-line $this->first nemůže být null, PHPStan to neví */
        $this->first->setPrev($node);
        $this->first = $node;
        $this->count++;
    }

    /**
     * Smaže poslední hodnotu v seznamu
     *
     * @return void
     *
     * @throws Exception
     */
    public function shift(): void
    {
        if (empty($this->first)) {
            throw new Exception('Nelze mazat z prázdného seznamu');
        }

        $this->first = $this->first->getNext();
        if (!empty($this->first)) {
            $node = $this->first->getPrev();
            unset($node);
        }

        $this->first?->setPrev(null);
        /** @phpstan-ignore-next-line $count nemůže být 0, PHPStan to neví */
        $this->count--;
    }

    /**
     * Přidá hodnotu na konec seznamu
     *
     * @param int|string $value
     *
     * @return void
     *
     * @throws Exception
     */
    public function push(int|string $value): void {
        /** @phpstan-ignore-next-line $this->last nemůže být null, PHPStan to neví */
        if ($this->compare($value, $this->last->getValue()) <= 0) {
            throw new Exception("Nelze přidat na konec, použij add()");
        }

        $node = new Node($value, $this->last, null);

        /** @phpstan-ignore-next-line $this->last nemůže být null, PHPStan to neví */
        $this->last->setNext($node);
        $this->last = $node;
        $this->count++;
    }

    /**
     * Přidá hodnotu do seznamu. Pokud už v seznamu stejné hodnoty existují, přidá novou hodnotu před první z nich
     *
     * @param int|string $value
     * @return void
     */
    public function add(int|string $value): void
    {
        // jedna nebo druhá část podmínky je true - zajištěno deklarací typu parametru
        if (!(((is_int($value) === true) && ($this->type === 'int')) ||
              ((is_string($value) === true) && ($this->type === 'string')))
        ) {
            throw new InvalidValueNodeTypeException($this->type);
        }

        // prázdný seznam, last null být u neprázdného seznamu nemůže, ale PHPStan jinak dál řve
        if ($this->first === null || $this->last === null) {
            $node = new Node($value, null, null);
            $this->first = $node;
            $this->last = $node;
            $this->count = 1;
        }
        // > než nejvyšší hodnota - přidávám na konec
      //  elseif ($this->compare($value, $this->last->getValue()) === 1) {
        elseif ($this->compare($value, $this->last->getValue()) === 1) {
            $this->push($value);
        }
        // <= nejnižší hodnota - přidávám na začátek
    //    elseif ($this->compare($value, $this->first->getValue()) === -1) {
        elseif ($this->compare($value, $this->first->getValue()) === -1) {
            $this->unshift($value);
        }
        // = nejvyšší hodnotě - přidám před poslední prvek
      //  elseif ($this->compare($value, $this->last->getValue()) === 0) {
        elseif ($this->compare($value, $this->last->getValue()) === 0) {
            $node = new Node($value, $this->last->getPrev(), $this->last);

            if ($this->last->getPrev() !== null) {
                $this->last->getPrev()->setNext($node);
            }
            else {
                $this->first = $node;
            }

            $this->last->setPrev($node);
            $this->count++;
        }
        // prvek uprostřed
        else {
            /** @var Node $current */
            $current = $this->first;
        //    while ($this->compare($current->getValue(), $value) === -1) {
            while ($this->compare($current->getValue(), $value) === -1) {
                /** @var Node $current */
                $current = $current->getNext();
            }

        //    if ($this->compare($current->getValue(), $value) >= 0) {
            if ($this->compare($current->getValue(), $value) >= 0) {
                $node = new Node($value, $current->getPrev(), $current);
                if ($current->getPrev() !== null) {
                    $current->getPrev()->setNext($node);
                }
                else {
                    $this->first = $node;
                }

                $current->setPrev($node);
            }
            else {
                /** @var Node $current */
                $node = new Node($value, $current, $current->getNext());
                /** @var Node $next */
                $next = $current->getNext();
                $next->setPrev($node);
                $current->setNext($node);
            }

            $this->count++;
        }
    }

    /**
     * Odstraní hodnotu ze seznamu
     *
     * @param string|int $value             hodnota, která se má odstranit
     * @param bool $deleteAllNodesWithValue true - odstraní všechny uzly se zadanou hodnotou, false - odtraní jen 1. výskyt
     *
     * @return void
     */
    public function delete(string|int $value, bool $deleteAllNodesWithValue = true): void
    {
        if ($this->count === 0 || $this->first === null || $this->last === null) {
            throw new NodeNotFoundException($value);
        }

        $found = false;
        $current = $this->first;

        // je to 1. prvek seznamu
      //  if ($this->first->getValue() === $value) {
        if ($this->compare($this->first->getValue(), $value) === 0) {
            if (
                ($this->count === 1) ||                                  // seznam má jen 1 Node
                ($this->compare($this->first->getValue(), $this->last->getValue()) === 0) // všechny Node mají stejnou hodnotu
            ) {
                while ($this->first !== null) {
                    $this->shift();
                  /*  $current = $this->first;
                    $this->first = $current->getNext();
                    unset($current); */

                    if ($deleteAllNodesWithValue === false) {
                        break;
                    }
                }

               // $this->first = null;
                $this->last = null;
             //   $this->count = 0;

                $found = true;
            }
            // seznam má více prvků
            else {
                // smaž všechny Node se stejnou hodnotou (musí být za sebou - je to setříděný seznam)
                do {
                    $current = $this->first;
                    /** @phpstan-ignore-next-line $this->first nemůže být null, PHPStan to neví */
                    $this->first = $this->first->getNext();
                    $this->first?->setPrev(null);
                    unset($current);
                    /** @phpstan-ignore-next-line count nemůže být 0, PHPStan to neví */
                    $this->count--;
                }
                // first nemůže být null, ale PHPStan to nevidí
                while (
                    /** @phpstan-ignore-next-line $this->first nemůže být null, PHPStan to neví */
                    ($this->first->getValue() === $value) &&
                    /** @phpstan-ignore-next-line $this->first nemůže být null, PHPStan to neví */
                    ($this->compare($this->first->getValue(), $value) === 0)
                    /** @phpstan-ignore-next-line $this->first nemůže být null, PHPStan to neví */
                    ($this->first->getNext() !== null) &&
                    ($deleteAllNodesWithValue === true)
                );

                $found = true;
            }
        }
        // je to poslední prvek sezamu
        // last nemůže být null, ale PHPStan to nevidí
        elseif ($this->compare($this->last->getValue(), $value) === 0) {
            // smaž všechny Node se stejnou hodnotou (musí být za sebou - je to setříděný seznam)
            do {
                $current = $this->last;
                $this->last = $this->last->getPrev();
                // @phpstan-ignore-next-line last nemůže být null, ale PHPStan to nevidí
                $this->last->setNext(null);
                unset($current);
                /** @phpstan-ignore-next-line count nemůže být 0, ale PHPStan to neví */
                $this->count--;
            }
            while (
                ($this->last !== null) &&
                ($this->last->getValue() === $value) &&
                ($this->last->getPrev() !== null) &&
                ($deleteAllNodesWithValue === true)
            );

            $found = true;
        }
        // je to prvek uprostřed seznamu
        else {
            do {
                $current = $current->getNext();
            }
            while (($current !== null) && ($current->getValue() !== $value));

            while (($current !== null) && ($current->getValue() === $value)) {
                // getPrev() nemůže být null, ale PHPStan to nevidí :-(
                $current->getPrev()?->setNext($current->getNext());
                // getNext() nemůže být null, ale PHPStan to nevidí :-(
                $current->getNext()?->setPrev($current->getPrev());
                $tmp = $current;
                unset($tmp);
                $current = $current->getNext();
                /** @phpstan-ignore-next-line count nemůže být 0, PHPStan to neví */
                $this->count--;
                $found = true;

                if ($deleteAllNodesWithValue === false) {
                    break;
                }
            }
        }

        if ($found === false) {
            throw new NodeNotFoundException($value);
        }
    }

    /**
     * Najde v seznamu všechny Node s hodnotou $value
     *
     * @param string|int $value
     *
     * @return array<int, Node>
     *
     * @throws NodeNotFoundException         Node se zadanou hodnotou nebyl nalezen
     * @throws InvalidValueNodeTypeException Hledaná hodnota je jiného typu než hodnoty v seznamu
     */
    public function search (string|int $value): array
    {
        if ($this->count === 0) {
            throw new NodeNotFoundException($value);
        }

        if (is_string($value) && $this->type === "int") {
            throw new InvalidValueNodeTypeException();
        }

        if (is_int($value) && $this->type === "string") {
            throw new InvalidValueNodeTypeException("string");
        }

        $found = false;
        $nodes = [];

        $current = $this->first;
        while ($current !== null) {
            if ($current->getValue() < $value) {
                $current = $current->getNext();
                continue;
            }

            if ($current->getValue() === $value) {
              $nodes[] = clone($current);
              $current = $current->getNext();
              $found = true;
              continue;
            }

            if ($current->getValue() > $value) {
                if ($found === true) {
                    break;
                }
                else {
                    throw new NodeNotFoundException($value);
                }
            }
        }

        if ($found === false) {
            throw new NodeNotFoundException($value);
        }

        return $nodes;
    }

    /**
     * Přidá do seznamu další setříděný seznam stejného typu
     *
     * @param LinkedList $linkedList
     *
     * @return LinkedList|$this
     *
     * @throws InvalidListTypeException Seznamy nejsou stejného typu
     */
    public function merge(LinkedList $linkedList): LinkedList
    {
        if ($this->type !== $linkedList->type) {
            throw new InvalidListTypeException();
        }

        if ($this->isEmpty()) {
            return $linkedList;
        }
        elseif ($linkedList->isEmpty()) {
            return $this;
        }
        else {
            /** @var Node $current1 */
            $current1 = $this->first;

            /** @phpstan-ignore-next-line $linkedList->first nemůže být null, PHPStan to neví */
            $current2 = clone($linkedList->first);

            /** @var Node $current1 */
            /** @var Node $current2 */
            while ($current1 !== null && $linkedList->first !== null) {
                while (($this->compare($current2->getValue(), $current1->getValue()) <= 0) && $linkedList->first !== null) {
                    $current2->setPrev($current1->getPrev());
                    $current2->setNext($current1);
                    $current1->setPrev($current2);
                    $this->count++;

                    if ($current2->getPrev() === null) {
                        $this->first = $current2;
                    }
                    else {
                        $current2->getPrev()->setNext($current2);
                    }

                    $linkedList->shift();
                    if ($linkedList->first !== null) {
                        $current2 = clone($linkedList->first);
                    }
                }

                $current1 = $current1->getNext();
            }
        }

        // to, co zbylo připoj na konec
        if ($linkedList->first !== null) {
           $current = $linkedList->first;
           $node = clone($linkedList->first);

           $node->setPrev($this->last);
           /** @phpstan-ignore-next line nemůže být null, ale PHPStan to nevidí */
           $this->last?->setNext($node);
           $this->count += $linkedList->count;

           $linkedList->first = $linkedList->first->getNext();
           unset($current);
           unset($linkedList);
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->count === 0;
    }

    /**
     * Převede seznam na řetězec hodnot oddělených PHP_EOL. Do závorek vypíše hodnoty předchozího/následujícího Node.
     *
     * @return string
     */
    public function __toString(): string
    {
        $text =
            ($this->count > 0) ?
                "LinkedList počet prvků: {$this->count}, typ hodnot: {$this->type}" . PHP_EOL :
                "LinkedList počet prvků: {$this->count}, typ hodnot: {$this->type}";

        $current = $this->first;
        while ($current !== null) {
            $text .= $current->__toString();

            if ($current->getNext() !== null) {
                $text .= PHP_EOL;
            }

            $current = $current->getNext();
        }

        return $text;
    }

    /**
     * Porovná 2 hodnoty. Pro int klasické porovnávání, pro stringy porovnávání podle ČSN pro pro třídění českých textů
     *
     * @param string|int $value1
     * @param string|int $value2
     *
     * @return int -1 pro $value1 < $value2, 0 pro $value1 = $value2, 1 pro $value1 > $value2
     */
    private function compare(string|int $value1, string|int $value2): int
    {
        // možná by bylo efektivnější jen nevědecky přetypovat na string?
        if (is_int($value1)) {
            if ($value1 < $value2) {
                return -1;
            }
            elseif ($value1 === $value2) {
                return 0;
            }
            else {
                return 1;
            }
        }
        else {
            // uvozovky kvůli PHPStanu
           // $compare = $this->compare("{$value1}", "{$value2}");
            $compare = $this->collator->compare("{$value1}", "{$value2}");

            if ($compare !== false) {
                return $compare;
            }
            else {
                throw new Exception('Chyba při porovnávání');
            }
        }
    }
}
