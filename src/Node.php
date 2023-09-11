<?php declare(strict_types = 1);

namespace LinkedList;

use _PHPStan_dfcaa3082\Nette\NotImplementedException;

require __DIR__ . '/../vendor/autoload.php';

class Node
{
    /**
     * Vytvoří nový Node.
     *
     * Případně je možno si vystačit jen s $next ukazateli, ovšem výrazně se tím zkomplikuje odebrání posledního prvku
     * v seznamu (bude nutné prolézt celý seznam od začátku až do konce jen proto, aby se poslednímu nastavilo next
     * na null). Samozřejmě ukazatelé zabírají nějaké místo v paměti. Nutno zvážit, jak často se bude poslední prvek
     * odebírat a co je důležitější, zda časová nebo paměťová náročnost.
     *
     * @param string|int $value hodnota musí odpovídat typu celého seznamu
     * @param Node|null $prev   předchozí prvek v seznamu
     * @param Node|null $next   následující prvek v seznamu
     */
    public function __construct(
      private string|int $value,
      private ?Node $prev,
      private ?Node $next
    )
    {

    }

    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * Neimplementováno. Ochrana proti tomu, aby někdo nemohl změnit hodnotu na jiný typ než je
     * (v konstruktoru se kontroluje, že je stejného typu jako celý seznam). Vzhledem k tomu, že je seznam
     * setříděný, tak by se při změně hodnoty stejně musel řešit i případný přesun.
     *
     * @param int|string $value
     * @return void
     */
    public function setValue(int|string $value): void
    {
        throw new NotImplementedException('Neimplementováno. Použij delete() a add()');
    }

    public function getPrev(): ?Node
    {
        return $this->prev;
    }

    public function setPrev(?Node $prev): void
    {
        $this->prev = $prev;
    }

    public function getNext(): ?Node
    {
        return $this->next;
    }

    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }

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

