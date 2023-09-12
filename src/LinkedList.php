<?php declare(strict_types = 1);

namespace LinkedList;

use Collator;
use Exception;
use LinkedList\Exceptions\InvalidListTypeException;
use LinkedList\Exceptions\InvalidValueNodeTypeException;
use LinkedList\Exceptions\NodeNotFoundException;

/**
 * A class for working with a sorted linked list.
 *
 * Can be considered to search for elements of BST creation, see e.g. https://stackoverflow.com/questions/6472885/bst-to-linked-list
 * In order for it to make sense, the list would probably have to be created first, then the BST and then the search,
 * because otherwise had to update BST every time a node was added/removed from the list.
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class LinkedList
{
    /** @var string Node values type */
    private string $type = 'int';

    /** @var Node|null the first node in sorted linked list */
    private ?Node $first = null;

    /** @var Node|null the last node in sorted linked list */
    private ?Node $last = null;

    /** @var non-negative-int the number of nodes in sorted linked list */
    private int $count = 0;

    /**
     * @var Collator for comparing texts by diacritics
     */
    private Collator $collator;

    /**
     * @param string $type nodes value type
     *
     * @throws Exception
     */
    public function __construct(
        string $type = 'int' // nodes value type
    ) {
        $this->type = $type;

        // for sorting according to system settings
        $collator = collator_create(locale_get_default());

        if ($collator === null) {
            throw new Exception('Error creating collator');
        }

        // to sort Prague 1, Prague 3 and Prague 10 in that order
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
     * Add a value to the beginning of the sorted linked list
     *
     * @param int|string $value
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function unshift(int|string $value): void {
        if (!(((is_int($value) === true) && ($this->type === 'int')) ||
            ((is_string($value) === true) && ($this->type === 'string')))
        ) {
            throw new InvalidValueNodeTypeException($this->type);
        }

        if ($this->first !== null && $this->compare($value, $this->first->getValue()) === 1) {
            throw new Exception("Can't add to begin, use add()");
        }

        $node = new Node($value, null, $this->first);

        $this->first?->setPrev($node);
        $this->first = $node;
        $this->count++;
    }

    /**
     * Remove the first node from sorted linked list
     *
     * @return void
     *
     * @throws Exception
     */
    public function shift(): void
    {
        if (empty($this->first)) {
            throw new Exception('Cannot delete from an empty list');
        }

        $this->first = $this->first->getNext();
        if (!empty($this->first)) {
            $node = $this->first->getPrev();
            unset($node);
        }

        $this->first?->setPrev(null);

        /** @phpstan-ignore-next-line $count can't be 0, PHPStan doesn't know that */
        $this->count--;
    }

    /**
     * Append a value to the end of a list
     *
     * @param int|string $value
     *
     * @return void
     *
     * @throws Exception
     */
    public function push(int|string $value): void {
        if (!(((is_int($value) === true) && ($this->type === 'int')) ||
            ((is_string($value) === true) && ($this->type === 'string')))
        ) {
            throw new InvalidValueNodeTypeException($this->type);
        }

        /** @phpstan-ignore-next-line $this->last can't be null, PHPStan doesn't know that */
        if ($this->compare($value, $this->last->getValue()) <= 0) {
            throw new Exception("Can't add to the end, use add()");
        }

        $node = new Node($value, $this->last, null);

        /** @phpstan-ignore-next-line $this->last can't be null, PHPStan doesn't know that */
        $this->last->setNext($node);
        $this->last = $node;
        $this->count++;
    }

    /**
     * Add a value to a list. If the same values already exist in the list, it adds the new value before the first one
     *
     * @param int|string $value
     * @return void
     *
     * @throws InvalidValueNodeTypeException bad type node value
     * @throws Exception compare exception
     */
    public function add(int|string $value): void
    {
        // one or the other part of the condition is true - ensured by the declaration of the parameter type
        if (!(((is_int($value) === true) && ($this->type === 'int')) ||
              ((is_string($value) === true) && ($this->type === 'string')))
        ) {
            throw new InvalidValueNodeTypeException($this->type);
        }

        // empty list, last null cannot be for a non-empty list, but PHPStan doesn't know that
        if ($this->first === null || $this->last === null) {
            $node = new Node($value, null, null);
            $this->first = $node;
            $this->last = $node;
            $this->count = 1;
        }
        // > than the highest value - I add to the end
        elseif ($this->compare($value, $this->last->getValue()) === 1) {
            $this->push($value);
        }
        // <= lowest value - I add to the beginning
        elseif ($this->compare($value, $this->first->getValue()) === -1) {
            $this->unshift($value);
        }
        // = to the highest value - I will add before the last element
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
        // a node in the middle
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

    /**
     * Remove the value from the sorted linked list
     *
     * @param string|int $value             the value to remove
     * @param bool $deleteAllNodesWithValue true - removes all nodes with the specified value, false - removes only the 1st occurrence
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function delete(string|int $value, bool $deleteAllNodesWithValue = true): void
    {
        if ($this->count === 0 || $this->first === null || $this->last === null) {
            throw new NodeNotFoundException($value);
        }

        $found = false;
        $current = $this->first;

        if ($this->compare($this->first->getValue(), $value) === 0) {
            // The sorted linked list contains only one element, or they all have the same value -
            // I delete everything in the list
            if (
                ($this->count === 1) ||                                                   // the list contains only 1 node
                ($this->compare($this->first->getValue(), $this->last->getValue()) === 0) // all nodes have the same value
            ) {
                while ($this->first !== null) {
                    $this->shift();

                    if ($deleteAllNodesWithValue === false) {
                        break;
                    }
                }

                $this->last = null;
                $found = true;
            }
            // the sorted linked list contains more nodes
            else {
                // delete all nodes with the same value (must be consecutive - it's a sorted list)
                  do {
                    $current = $this->first;
                    /** @phpstan-ignore-next-line $this->first can't be null, PHPStan doesn't know that */
                    $this->first = $this->first->getNext();
                    /** @phpstan-ignore-next-line $this->first can't be null, PHPStan doesn't know that */
                    $this->first->setPrev(null);
                    unset($current);
                    /** @phpstan-ignore-next-line $this->count can't be null, PHPStan doesn't know that */
                    $this->count--;
                }
                while (
                    /** @phpstan-ignore-next-line $this->first can't be null, PHPStan doesn't know that */
                    ($this->compare($this->first->getValue(), $value) === 0) &&
                    /** @phpstan-ignore-next-line $this->first can't be null, PHPStan doesn't know that */
                    ($this->first->getNext() !== null) &&
                    ($deleteAllNodesWithValue === true)
                );

                $found = true;
            }
        }
        // it's the last node in the sorted linked list
        // $this->last can't be null, PHPStan doesn't know that
        elseif ($this->compare($this->last->getValue(), $value) === 0) {
            // delete all Nodes with the same value (must be consecutive - it's a sorted list)
            do {
                $current = $this->last;
                $this->last = $this->last->getPrev();
                // @phpstan-ignore-next-line $this->last can't be null, PHPStan doesn't know that
                $this->last->setNext(null);
                unset($current);
                /** @phpstan-ignore-next-line $this->count can't be 0, PHPStan doesn't know that */
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
        // it's the node in the middle of the list
        else {
            do {
                $current = $current->getNext();
            }
            while (($current !== null) && ($current->getValue() !== $value));

            while (($current !== null) && ($current->getValue() === $value)) {
                /** @phpstan-ignore-next-line $current->getPrev() can't be null, PHPStan doesn't know that */
                $current->getPrev()->setNext($current->getNext());
                /** @phpstan-ignore-next-line $current->getPrev() can't be null, PHPStan doesn't know that */
                $current->getNext()->setPrev($current->getPrev());
                $tmp = $current;
                unset($tmp);
                $current = $current->getNext();
                /** @phpstan-ignore-next-line count can't be null, PHPStan doesn't know that */
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
     * Finds all Nodes with value = $value in the list
     *
     * @param string|int $value
     *
     * @return array<int, Node>
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     * @throws InvalidValueNodeTypeException The searched value is of a different type than the values in the list
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
     * Add another sorted list of the same type to the list
     *
     * @param LinkedList $linkedList
     *
     * @return LinkedList|$this
     *
     * @throws InvalidListTypeException The lists are not of the same type
     *
     * @throws InvalidListTypeException bad list values type
     * @throws Exception compare exception
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

            /** @phpstan-ignore-next-line $linkedList->first can't be null, PHPStan doesn't know that */
            $current2 = clone($linkedList->first);


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

        // add what's left to the end
        if ($linkedList->first !== null) {
           $current = $linkedList->first;
           $node = clone($linkedList->first);

           $node->setPrev($this->last);
           /** @phpstan-ignore-next line can't be null, PHPStan doesn't know that */
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
     * Converts a list to a string of PHP_EOL separated values. Writes the values of the previous/next Node
     * in parentheses. For testing purposes.
     *
     * @return string
     */
    public function __toString(): string
    {
        $text =
            ($this->count > 0) ?
                "LinkedList number of nodes: {$this->count}, values type: {$this->type}" . PHP_EOL :
                "LinkedList number of nodes: {$this->count}, values type: {$this->type}";

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
     * Compares 2 values. For int classic comparison, for strings comparison according to the set localization
     * in the system.
     *
     * @param string|int $value1
     * @param string|int $value2
     *
     * @return int -1 if $value1 < $value2, 0 if $value1 = $value2, 1 if $value1 > $value2
     *
     * @throws Exception error
     */
    private function compare(string|int $value1, string|int $value2): int
    {
        // maybe it would be more efficient to just cast to string?
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
            // quotes because of PHPStan
            $compare = $this->collator->compare("{$value1}", "{$value2}");

            if ($compare !== false) {
                return $compare;
            }
            else {
                throw new Exception('Comparison error');
            }
        }
    }
}
