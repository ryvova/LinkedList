<?php declare(strict_types = 1);

namespace LinkedList;

use Exception;

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
abstract class LinkedList
{
    /** @var string Node values type */
    protected string $type = 'int';

    /** @var Node|null the first node in sorted linked list */
    protected ?Node $first = null;

    /** @var Node|null the last node in sorted linked list */
    protected ?Node $last = null;

    /** @var non-negative-int the number of nodes in sorted linked list */
    protected $count = 0;

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

    /**
     * Return the number of nodes in the list
     *
     * @return non-negative-int
     */
    public function getCount()
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
    public function addToBegin(int|string $value): void {
        $node = new Node($value, null, $this->first);

        if ($this->count === 0) {
            $this->first = $node;
            $this->last = $node;
            $this->count = 1;
        } 
        else {
            $this->first?->setPrev($node);
            $this->first = $node;
            $this->count++;
        }
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
    public function appendToEnd(int|string $value): void {
        $node = new Node($value, $this->last, null); 

        /** @phpstan-ignore-next-line $this->last can't be null, PHPStan doesn't know that */
        $this->last->setNext($node);
        $this->last = $node;
        $this->count++;
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
        $class = substr(static::class, strrpos(static::class, '\\') + 1);

        $text = "{$class} number of nodes: {$this->count}";

        $current = $this->first;
        while ($current !== null) {
            $text .= PHP_EOL . $current->__toString();

            $current = $current->getNext();
        }

        return $text;
    }
}
