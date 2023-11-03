<?php declare(strict_types = 1);

namespace LinkedList;

use Collator;
use Exception;
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
class StringLinkedList extends LinkedList
{
    /**
     * @var Collator for comparing texts by diacritics
     */
    private Collator $collator;

    /**
     * @throws Exception
     */
    public function __construct() {
        // for sorting according to system settings
        $collator = collator_create(locale_get_default());

        if ($collator === null) {
            throw new Exception('Error creating collator');
        }

        // to sort Prague 1, Prague 3 and Prague 10 in that order
        $collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::ON);

        $this->collator = $collator; 
    } 
    
    /**
     * Add a value to the beginning of the sorted linked list
     *
     * @param string $value
     * @return void
     *
     * @throws Exception the value cannot be at the beginning of the list
     */
    public function unshift(string $value): void {
        if (($this->first !== null) && ($this->compare((string) $this->first->getValue(), $value) === -1)) {
            throw new Exception("Can't add to begin, use add()");
        }
       
        parent::addToBegin($value);
    }  

    /**
     * Append a value to the end of a list
     *
     * @param string $value
     *
     * @return void
     *
     * @throws Exception
     */
    public function push(string $value): void {
        /** @phpstan-ignore-next-line $this->last can't be null, PHPStan doesn't know that */
        if ($this->compare($value, $this->last->getValue()) <= 0) {
            throw new Exception("Can't add to the end, use add()");
        }

        parent::appendToEnd($value);
    } 

    /**
     * Add a value to a list. If the same values already exist in the list, it adds the new value before the first one
     *
     * @param string $value
     * @return void
     *
     * @throws Exception compare exception
     */
    public function add(string $value): void
    {
        // empty list or value <= lowest value last null cannot be for a non-empty list, but PHPStan doesn't know that
        if (($this->count === 0) || ($this->compare($value, (string) $this->first?->getValue()) <= 0)) {
            $this->unshift($value);
        }
        // > than the highest value - I add to the end
        elseif ($this->compare($value, (string) $this->last?->getValue()) === 1) {
            $this->push($value);
        }
        // = to the highest value - I will add before the last element
        elseif ($this->compare($value, (string) $this->last?->getValue()) === 0) {
            $node = new Node($value, $this->last?->getPrev(), $this->last);

            if ($this->last?->getPrev() !== null) {
                $this->last->getPrev()->setNext($node);
            }
            else {
                $this->first = $node;
            }

            $this->last?->setPrev($node);
            $this->count++;
        }
        // a node in the middle
        else {
            /** @var Node $current */
            $current = $this->first;
            while ($this->compare((string) $current->getValue(), $value) === -1) {
                /** @var Node $current */
                $current = $current->getNext();
            }

            if ($this->compare((string) $current->getValue(), $value) >= 0) {
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
     * @param string $value             the value to remove
     * @param bool $deleteAllNodesWithValue true - removes all nodes with the specified value, false - removes only the 1st occurrence
     *
     * @return void
     *
     * @throws Exception compare error
     */
    public function delete(string $value, bool $deleteAllNodesWithValue = true): void
    {
        if ($this->count === 0) {
            throw new NodeNotFoundException($value);
        }

        $found = false;
        $current = $this->first;

        if ($this->compare((string) $this->first?->getValue(), $value) === 0) {
            // The sorted linked list contains only one element, or they all have the same value -
            // I delete everything in the list
            if (
                ($this->count === 1) ||                                                   // the list contains only 1 node
                ($this->compare((string) $this->first?->getValue(), (string) $this->last?->getValue()) === 0) // all nodes have the same value
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
        elseif ($this->compare((string) $this->last?->getValue(), $value) === 0) {
            // delete all Nodes with the same value (must be consecutive - it's a sorted list)
            do {
                $current = $this->last;
                $this->last = $this->last?->getPrev();
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
                $current = $current?->getNext();
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
     * @param string $value
     *
     * @return array<int, Node>
     *
     * @throws NodeNotFoundException         A node with the specified value was not found in the list
     */
    public function search (string $value): array
    {
        if ($this->count === 0) {
            throw new NodeNotFoundException($value);
        }

        $found = false;
        $nodes = [];

        $current = $this->first;
        while ($current !== null) {
            if ($this->compare((string) $current->getValue(), $value) === -1) {
                $current = $current->getNext();
                continue;
            }

            if ($this->compare((string) $current->getValue(), $value) === 0) {
              $nodes[] = clone($current);
              $current = $current->getNext();
              $found = true;
              continue;
            }

            if ($this->compare((string) $current->getValue(), $value) === 1) {
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
     * @param StringLinkedList $stringLinkedList
     *
     * @return StringLinkedList|$this
     *
     * @throws Exception                compare exception
     */
    public function merge(StringLinkedList $stringLinkedList): LinkedList
    {
        if ($this->isEmpty()) {
            return $stringLinkedList;
        }
        elseif ($stringLinkedList->isEmpty()) {
            return $this;
        }
        else {
            /** @var Node $current1 */
            $current1 = $this->first;

            /** @phpstan-ignore-next-line $linkedList->first can't be null, PHPStan doesn't know that */
            $current2 = clone($stringLinkedList->first);


            /** @var Node $current2 */
            while (($current1 !== null) && ($stringLinkedList->first !== null)) {
                while (($this->compare((string) $current2->getValue(), (string) $current1->getValue()) <= 0) && ($stringLinkedList->first !== null)) {
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

                    $stringLinkedList->shift();
                    if ($stringLinkedList->first !== null) {
                        $current2 = clone($stringLinkedList->first);
                    }
                }

                $current1 = $current1->getNext();
            }
        }

        // add what's left to the end
        if ($stringLinkedList->first !== null) {
           $current = $stringLinkedList->first;
           $node = clone($stringLinkedList->first);

           $node->setPrev($this->last);
           $this->last?->setNext($node);
           $this->count += $stringLinkedList->count;

           $stringLinkedList->first = $stringLinkedList->first->getNext();
           unset($current);
           unset($stringLinkedList);
        }

        return $this;
    } 

    /**
     * Compares 2 values. For int classic comparison, for strings comparison according to the set localization
     * in the system.
     *
     * @param string $value1
     * @param string $value2
     *
     * @return int -1 if $value1 < $value2, 0 if $value1 = $value2, 1 if $value1 > $value2
     *
     * @throws Exception error
     */
    public function compare(string $value1, string $value2): int
    {
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
