<?php declare(strict_types = 1);

namespace LinkedList;

use LinkedList\Exceptions\NotImplementedException;

/**
 * A class implements Node in double sorted double linked list
 *
 * @author: Anna Rývová (anna.ryvova@gmail.com)
 * @copyright:Copyright (c) 2023, Anna Rývová
 */
class Node
{
    /**
     * Create a new Node.
     *
     * Alternatively, it is possible to make do with just $next pointers, but this will significantly complicate
     * the removal of the last element in a list (it will be necessary to traverse the entire list from beginning
     * to end just to set next to the last one to null). Of course pointers take up some space in memory.
     * It is necessary to consider how often the last element will be deleted and and whether time or memory
     * consumption is more important.
     *
     * @param string|int $value hodnota musí odpovídat typu celého seznamu
     * @param Node|null $prev   předchozí prvek v seznamu
     * @param Node|null $next   následující prvek v seznamu
     */
    public function __construct(
      private readonly string|int $value, // node value
      private ?Node $prev,       // previous node
      private ?Node $next        // next node
    )
    {
    }

    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * Not implemented. Since the list is sorted, in addition to checking the type of the value, one would have to move
     * the Node to the corresponding place in the list if the Node is in any list. If necessary, it could be programmed
     * so that if the new value is lower, only the previous part of the list is scrolled, otherwise the next part
     * is scrolled.
     *
     * @param int|string $value
     *
     * @return void
     *
     * @throws NotImplementedException method is not implemented - property is readonly
     */
    public function setValue(int|string $value): void
    {
        throw new NotImplementedException(
            'Not implemented. To change the value in a Node in the list, use delete() and add()'
        );
    }

    public function getPrev(): ?Node
    {
        return $this->prev;
    }

    /**
     * Set pointer to the previous Node in sorted linked list
     *
     * A node can be part of any list, not just a sorted one, so I don't check the value against the value
     * of the previous node
     *
     * @param Node|null $prev
     *
     * @return void
     */
    public function setPrev(?Node $prev): void
    {
        $this->prev = $prev;
    }

    public function getNext(): ?Node
    {
        return $this->next;
    }

    /**
     * Set pointer to next Node in sorted linked list
     *
     * A node can be part of any list, not just a sorted one, so I don't check the value against the value
     * of the previous node
     *
     * @param Node|null $next
     *
     * @return void
     */
    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }

    /**
     * Convert Node into list. For testing purposes.
     *
     * @return String
     */
    public function __toString(): String
    {
        $textPrev =
            ($this->prev === null) ?
                'null' :
                $this->prev->getValue();

        $textNext =
            ($this->next === null) ?
                'null' :
                $this->next->value;

        return "{$this->value} (prev: {$textPrev}, next: {$textNext})";
    }
}

