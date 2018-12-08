<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;
use Fewbricks\Helpers\Helper;

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
     * @param null $key
     * @return $this
     */
    public function addItem($item, $key = null)
    {

        $this->finalizeItem($item);
        $this->validateItem($item);

        if (is_null($key)) {

            array_push($this->items, $item);

        } else {

            if(isset($this->items[$key])) {

                Helper::fewbricksDie('Fewbricks says: trying to add an item with the key "' . $key . '".
                The key already exists for a field and keys must be unique.');

            }

            $this->items[$key] = $item;

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $keyToAddAfter
     * @param null|string $keyOfNewItem
     * @return $this
     */
    public function addItemAfterItemByKey($item, string $keyToAddAfter, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddAfter = $this->getPositionForItemByKey($keyToAddAfter))) {

            $this->finalizeItem($item);
            $this->validateItem($item);

            if (is_null($keyOfNewItem)) {
                $newItem = [$item];
            } else {

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
     * @param string $keyOfFieldToAddBefore
     * @param null|string $keyOfNewItem
     * @return $this
     */
    public function addItemBeforeItemByKey($item, string $keyOfFieldToAddBefore, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddBefore = $this->getPositionForItemByKey($keyOfFieldToAddBefore))) {

            $this->finalizeItem($item);
            $this->validateItem($item);

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

        $this->finalizeItem($item);
        $this->validateItem($item);

        if ($keyOfNewItem === false) {

            array_unshift($this->items, $item);

        } else {

            $this->items = array_merge([$keyOfNewItem => $item], $this->items);

        }

        return $this;

    }

    /**
     * @param array $items
     * @return $this
     */
    public function addItemsToBeginning(array $items)
    {

        foreach ($items AS $item) {
            $this->finalizeItem($item);
            $this->validateItem($item);
        }

        $this->items = array_merge($items, $this->items);

        return $this;

    }

    /**
     * Empty function on purpose allowing child classes to overwrite it as needed and not having to implement it if not
     * needed.
     * @param $item
     */
    protected function finalizeItem($item)
    {

    }

    /** @noinspection PhpUnusedParameterInspection */
    /**
     * Empty function on purpose allowing child classes to overwrite it as needed and not having to implement it if not
     * needed.
     * @param Field $item
     * @return bool
     */
    protected function validateItem($item)
    {

        return true;

    }

    /**
     * @param $key
     * @return mixed
     */
    public function getItemByKey(string $key)
    {

        $foundItem = false;

        if (isset($this->items[$key])) {

            $foundItem = $this->items[$key];

        }

        return $foundItem;

    }

    /**
     * @param string $keyToSearchFor
     * @return bool|int
     */
    public function getPositionForItemByKey(string $keyToSearchFor)
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

        foreach ($this->items AS $itemKey => $item) {

            if ($item->$functionName() === $value) {
                $this->removeItem($itemKey);
            }

        }

        return $this;

    }

}
