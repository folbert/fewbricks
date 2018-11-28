<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;

/**
 * Class Collection
 *
 * @package Fewbricks
 */
class Collection
{

    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     */
    public function __construct()
    {

        $this->items = [];

    }

    /**
     * @param mixed $item
     * @param null  $key
     * @return $this
     */
    public function addItem($item, $key = null)
    {

        if (is_null($key)) {

            array_push($this->items, $item);

        } else {

            if ($this->validateKey($item, $key)) {

                $this->items[$key] = $item;

            }

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $keyToAddAfter
     * @param null $keyOfNewItem
     * @return $this
     */
    public function addItemAfter($item, $keyToAddAfter, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddAfter = $this->getItemIndex($keyToAddAfter))) {

            if (is_null($keyOfNewItem)) {
                $newItem = [$item];
            } else {

                $this->validateKey($item, $keyOfNewItem);
                $newItem = [$keyOfNewItem => $item];

            }

            $this->items = array_merge(
                array_slice($this->items, 0, ($positionToAddAfter + 1)),
                $newItem,
                array_slice($this->items, ($positionToAddAfter + 1))
            );

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $keyToAddBefore
     * @param null $keyOfNewItem
     * @return $this
     */
    public function addItemBefore($item, $keyToAddBefore, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddBefore = $this->getItemIndex($keyToAddBefore))) {

            if (is_null($keyOfNewItem)) {
                $newItem = [$item];
            } else {
                $newItem = [$keyOfNewItem => $item];
            }

            $this->items = array_merge(
                array_slice($this->items, 0, $positionToAddBefore),
                $newItem,
                array_slice($this->items, $positionToAddBefore)
            );

        }

        return $this;

    }

    /**
     * @param mixed $item
     * @param bool $keyOfNewItem
     * @return $this
     */
    public function addItemToBeginning($item, $keyOfNewItem = false)
    {

        if ($keyOfNewItem === false) {

            array_unshift($this->items, $item);

        } else {

            $this->items = array_merge([$keyOfNewItem => $item], $this->items);

        }

        return $this;

    }

    /**
     * @param $items
     * @return $this
     */
    public function addItemsToBeginning($items)
    {

        $this->items = array_merge($items, $this->items);

        return $this;

    }

    /**
     * @param $key
     * @return mixed
     */
    public function getItem($key)
    {

        $item = false;

        if (isset($this->items[$key])) {

            $item = $this->items[$key];

        }

        return $item;

    }

    /**
     * @param string $keyToSearchFor
     * @return bool|int
     */
    public function getItemIndex($keyToSearchFor)
    {

        $position = false;

        $positionTracker = 0;

        foreach ($this->items AS $key => $item) {

            if ($key === $keyToSearchFor) {

                $position = $positionTracker;
                break;

            }

            $positionTracker++;

        }

        return $position;

    }

    /**
     * @return mixed
     */
    public function getItems()
    {

        return $this->items;

    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->items);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->getLength() === 0;
    }

    /**
     * @param $key
     * @return bool
     */
    public function keyExists($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * @param $key
     * @return Collection
     */
    public function removeItem($key)
    {

        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }

        return $this;

    }

    /**
     * @param string $functionName
     * @param mixed $value
     * @return $this
     */
    public function removeItemByFunctionValue($functionName, $value)
    {

        foreach($this->items AS $itemKey => $item) {

            if($item->$functionName() === $value) {
                $this->removeItem($itemKey);
            }

        }

        return $this;

    }

    /**
     * @param mixed $item
     * @param string $key
     * @param bool $die_on_invalid
     * @return bool
     */
    public function validateKey($item, $key, $die_on_invalid = true)
    {

        $key_is_valid = true;

        if (isset($this->items[$key])) {

            $key_is_valid = false;

            if($die_on_invalid) {

                $message = '';

                if (method_exists($item, 'getLabel')) {

                    $message .= 'Error when attempting to register the item with the key "' . $key . '" and label "'
                        . $item->getLabel() . '". The key is already used by an item named "'
                        . $this->items[$key]->getLabel() . '" and keys must be unique.';

                } else {

                    $message .= 'Error when attempting to register the item with the key ' . $key;

                }

                $message
                    .= '<br><br>Pro-tip: create your keys manually by using the current date and time . So if you
are creating a field at 09:59 on December 11 2017, the key might be "1712110959a" . Note the addition of an extra
character to ensure that ACF can use the key but also to make sure that if you create another key within the same
minute, you can simply append some other "random" letter to that key like "1712110989x"';

                wp_die($message);

            }

        }

        return $key_is_valid;

    }

}
