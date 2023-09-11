<?php declare(strict_types = 1);

namespace LinkedList;

use Collator;
use Exception;
use LinkedList\Exceptions\InvalidListTypeException;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\Exceptions\NodeNotFoundException;

require __DIR__ . '/../vendor/autoload.php';

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
     * @var Collator
     */
    private Collator $collator;

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

  /*  public function setFirst(Node $node): void
    {
        $this->first = $node;
    } */

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
        elseif ($this->compare($value, $this->last->getValue()) === 1) {
            $this->push($value);
        }
        // <= nejnižší hodnota - přidávám na začátek
        elseif ($this->compare($value, $this->first->getValue()) === -1) {
            $this->unshift($value);
        }
        // = nejvyšší hodnotě - přidám před poslední prvek
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
            while ($this->compare($current->getValue(), $value) === -1) {
                /** @var Node $current */
                $current = $current->getNext();
            }

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

    public function delete(string|int $value, bool $deleteAllNodesWithValue = true): void
    {
        if ($this->count === 0 || $this->first === null || $this->last === null) {
            throw new NodeNotFoundException($value);
        }

        $found = false;
        $current = $this->first;

        // je to 1. prvek seznamu
        if ($this->first->getValue() === $value) {
            if (
                ($this->count === 1) ||                                  // seznam má jen 1 Node
                ($this->first->getValue() === $this->last->getValue()) // všechny Node mají stejnou hodnotu
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
                    $this->first = $this->first->getNext();
                    $this->first?->setPrev(null);
                    unset($current);
                    /** @phpstan-ignore-next-line count nemůže být 0, PHPStan to neví */
                    $this->count--;
                }
                // first nemůže být null, ale PHPStan to nevidí
                while (
                    ($this->first?->getValue() === $value) &&
                    ($this->first->getNext() !== null) &&
                    ($deleteAllNodesWithValue === true)
                );

                $found = true;
            }
        }
        // je to poslední prvek sezamu
        // last nemůže být null, ale PHPStan to nevidí
        elseif ($this->last->getValue() === $value) {
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

            echo $this->__toString(). PHP_EOL . PHP_EOL;
            echo $linkedList->__toString() . PHP_EOL . PHP_EOL;
            echo '------' . PHP_EOL . PHP_EOL;

         //   $linkedList->delete($current2->getValue(), false);

            while ($current1 !== null && $linkedList->first !== null) {
             //   echo '>' . $current1->getValue() . ' - ' . $current2->getValue() . PHP_EOL;
                /** @phpstan-ignore-next-line $current2 ani $current1 nemůže být null, PHPStan to neví */
                while (($this->compare($current2->getValue(), $current1->getValue()) <= 0) && $linkedList->first !== null) {
                 //   echo $current1->getValue() . ' - ' . $current2->getValue() . PHP_EOL;
                    /** @phpstan-ignore-next-line $current2 nemůže být null, PHPStan to neví */
                    $current2->setPrev($current1->getPrev());
                    /** @phpstan-ignore-next-line $current2 nemůže být null, PHPStan to neví */
                    $current2->setNext($current1);
                    $current1->setPrev($current2);
                    $this->count++;

                    /** @phpstan-ignore-next-line $current2 nemůže být null, PHPStan to neví */
                    if ($current2->getPrev() === null) {
                        $this->first = $current2;
                    }
                    else {
                        /** @phpstan-ignore-next-line $current2 nemůže být null, PHPStan to neví */
                        $current2->getPrev()->setNext($current2);
                    }

                    $linkedList->shift();
                    if ($linkedList->first !== null) {
                        $current2 = clone($linkedList->first);
                    }

                    echo $this->__toString() . PHP_EOL . PHP_EOL;
                    echo $linkedList->__toString(). PHP_EOL . PHP_EOL;
                    echo '------' . PHP_EOL . PHP_EOL;
                 //   $current2 = $current2->getNext();
                }

                $current1 = $current1->getNext();
            }
        }

        echo "xxxxxxxxxxxxxxxxxxxxx" . PHP_EOL . PHP_EOL;

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

           echo $this->__toString() . PHP_EOL . PHP_EOL;
           //  echo $linkedList->__toString(). PHP_EOL . PHP_EOL;
           echo '------' . PHP_EOL . PHP_EOL;
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