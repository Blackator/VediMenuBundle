<?php

namespace Blackator\Bundle\VediMenuBundle\Component;

class MenuItemsCollection implements \Iterator, \ArrayAccess, \Countable
{
    protected $items = [];

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function current(): ?MenuItem
    {
        return current($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid()
    {
        return current($this->items) !== false;
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function offsetExists($offset)
    {
        if (!is_int($offset)) throw new \InvalidArgumentException('Type of "offset" argument must be "Int"');
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): ?MenuItem
    {
        if (!is_int($offset)) throw new \InvalidArgumentException('Type of "offset" argument must be "Int"');
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if ($offset !== null && !is_int($offset)) throw new \InvalidArgumentException('Type of "offset" argument must be "Int" or "null"');
        if (!is_object($value) || get_class($value) !== MenuItem::class) throw new \InvalidArgumentException('Type of "value" argument must be "Blackator\Bundle\MenuBundle\Component\MenuItem"');
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (!is_int($offset)) throw new \InvalidArgumentException('Type of "offset" argument must be "Int"');
        unset($this->items[$offset]);
    }

    public function sortByIndex()
    {
        usort($this->items, function ($a, $b) {
            return ($a->getIndex() <=> $b->getIndex());
        });
    }

    public function sortByCaption()
    {
        usort($this->items, function ($a, $b) {
            return ($a->getCaption() <=> $b->getCaption());
        });
    }
}