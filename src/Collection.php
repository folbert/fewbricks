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

            $this->items[$key] = $item;

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $key_to_add_after
     * @param null $key_of_new_item
     * @return $this
     */
    public function addItemAfterItemByKey($item, $key_to_add_after, $key_of_new_item = null)
    {

        if (false !== ($position_to_add_after = $this->getItemPositionForKey($key_to_add_after))) {

            $this->finalizeItem($item);
            $this->validateItem($item);

            if (is_null($key_of_new_item)) {
                $newItem = [$item];
            } else {

                $newItem = [$key_of_new_item => $item];

            }

            $this->items = array_merge(
                array_slice($this->items, 0, ($position_to_add_after + 1)),
                $newItem,
                array_slice($this->items, ($position_to_add_after + 1))
            );

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $key_of_field_to_add_before
     * @param null $key_of_new_item
     * @return $this
     */
    public function addItemBeforeItemByKey($item, $key_of_field_to_add_before, $key_of_new_item = null)
    {

        if (false !== ($position_to_add_before = $this->getItemPositionForKey($key_of_field_to_add_before))) {

            $this->finalizeItem($item);
            $this->validateItem($item);

            if (is_null($key_of_new_item)) {
                $newItem = [$item];
            } else {
                $newItem = [$key_of_new_item => $item];
            }

            $this->items = array_merge(
                array_slice($this->items, 0, $position_to_add_before),
                $newItem,
                array_slice($this->items, $position_to_add_before)
            );

        }

        return $this;

    }

    /**
     * @param mixed $item
     * @param bool $key_of_new_item
     * @return $this
     */
    public function addItemToBeginning($item, $key_of_new_item = false)
    {

        $this->finalizeItem($item);
        $this->validateItem($item);

        if ($key_of_new_item === false) {

            array_unshift($this->items, $item);

        } else {

            $this->items = array_merge([$key_of_new_item => $item], $this->items);

        }

        return $this;

    }

    /**
     * @param $items
     * @return $this
     */
    public function addItemsToBeginning($items)
    {

        foreach ($items AS $item) {
            $this->finalizeItem($item);
            $this->validateItem($item);
        }

        $this->items = array_merge($items, $this->items);

        return $this;

    }

    protected function finalizeItem($item)
    {

    }

    /**
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
    public function getItemByKey($key)
    {

        $found_item = false;

        if (isset($this->items[$key])) {

            $found_item = $this->items[$key];

        }

        return $found_item;

    }

    /**
     * @param string $key_to_search_for
     * @return bool|int
     */
    public function getItemPositionForKey($key_to_search_for)
    {

        $position = false;

        $position_tracker = 0;

        foreach ($this->items AS $key => $item) {

            if ($key === $key_to_search_for) {

                $position = $position_tracker;
                break;

            }

            $position_tracker++;

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

    /**
     * Keys only need to be validated against keys in the same collection since fields in a collection
     * always gets its key prefix from the field group.
     * @param string $key_to_validate
     * @param mixed $item_to_validate
     * @param bool $die_on_invalid
     * @return bool
     */
    public function validateKey(string $key_to_validate, $item_to_validate, $die_on_invalid = true)
    {

        $key_is_valid = true;

        if (isset($this->items[$key_to_validate])) {

            $key_is_valid = false;

            if ($die_on_invalid) {

                $message = '';

                $message .= 'Error when attempting to register the item with the key "' . $key_to_validate . '"';

                if (method_exists($item_to_validate, 'getLabel')) {
                    $message .= ' and label "' . $item_to_validate->getLabel() . '"';
                }

                $message .= '. ';

                $message .= 'The key is already in use';

                $existing_item = $this->getItemByKey($key_to_validate);

                if ($existing_item !== false && method_exists($existing_item, 'getLabel')) {

                    $message .= ' by an item named
                    "' . $existing_item->getLabel() . '" and keys must be unique';

                }

                $message .= '.';

                $message
                    .= '<br><br>Pro-tip: create your keys manually by using the current date and time . So if you
are creating a field at 15:00 on December 24 2019, the key might be "1912241500a". Note the addition of an extra
character to ensure that ACF can use the key but also to make sure that if you create another key within the same
minute, you can simply append some other "random" letter to that key like "1912241500x"';

                wp_die($message);

            }

        }

        return $key_is_valid;

    }

}
