<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;
use Fewbricks\Exceptions\DuplicateKeyException;
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
    public function add_item($item, $key = null)
    {

        $this->finalize_item($item);
        $this->validate_item($item);

        if (is_null($key)) {

            array_push($this->items, $item);

        } else {

            $tmpKey = $item->get_key_prefix_from_parents() . $key;

            // If parents are not empty, we are dealing with an item that will get parents keys prepended to its own
            // and if the key is still non unique after that, it will be caught by the field group.
            if(isset($this->items[$tmpKey])) {

                $message = 'Fewbricks says: trying to add an item with the key "' . $key . '". The key already exists
                for a field and keys must be unique.';

                if(!empty($item->get_parents())) {

                    $message .= '<p>If the field with the key resides in a Brick, please note that the reason for
                    duplicate keys can be that you have created two instances of the Brick using the same key. Below is
                    a list of keys of parents which includes Bricks.<ul>';


                    foreach($item->get_parents() AS $parent) {
                        $message .= '<li>' . $parent['key'] . ' - ' . $parent['name'] . ' - ' . $parent['type'];
                    }

                    $message .= '</ul>';

                }

                Helper::fewbricks_die($message, DuplicateKeyException::class);

            }

            $this->items[$tmpKey] = $item;

        }

        return $this;

    }

    /**
     * @param Field $item
     * @param string $keyToAddAfter
     * @param null|string $keyOfNewItem
     * @return $this
     */
    public function add_item_after_item_by_key($item, string $keyToAddAfter, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddAfter = $this->get_position_for_item_by_key($keyToAddAfter))) {

            $this->finalize_item($item);
            $this->validate_item($item);

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
    public function add_item_before_item_by_key($item, string $keyOfFieldToAddBefore, $keyOfNewItem = null)
    {

        if (false !== ($positionToAddBefore = $this->get_position_for_item_by_key($keyOfFieldToAddBefore))) {

            $this->finalize_item($item);
            $this->validate_item($item);

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
    public function add_item_to_beginning($item, $keyOfNewItem = false)
    {

        $this->finalize_item($item);
        $this->validate_item($item);

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
    public function add_items_to_beginning(array $items)
    {

        foreach ($items AS $item) {
            $this->finalize_item($item);
            $this->validate_item($item);
        }

        $this->items = array_merge($items, $this->items);

        return $this;

    }

    /**
     * Empty function on purpose allowing child classes to overwrite it as needed and not having to implement it if not
     * needed.
     * @param $item
     */
    protected function finalize_item($item)
    {

    }

    /** @noinspection PhpUnusedParameterInspection */
    /**
     * Empty function on purpose allowing child classes to overwrite it as needed and not having to implement it if not
     * needed.
     * @param Field $item
     * @return bool
     */
    protected function validate_item($item)
    {

        return true;

    }

    /**
     * @param $keyToSearchFor
     * @return mixed
     */
    public function get_item_by_key(string $keyToSearchFor)
    {

        $foundItem = false;

        foreach($this->items AS $key => $item) {

            if($this->key_search_match($keyToSearchFor, $key, $item)) {

                $foundItem = $item;
                break;

            }

        }

        return $foundItem;

    }

    /**
     * @param string $keyToSearchFor
     * @return bool|int
     */
    public function get_position_for_item_by_key(string $keyToSearchFor)
    {

        $position = false;

        $positionTracker = 0;

        foreach ($this->items AS $key => $item) {

            if ($this->key_search_match($keyToSearchFor, $key, $item)) {

                $position = $positionTracker;
                break;

            }

            $positionTracker++;

        }

        return $position;

    }

    /**
     * @param $keyToSearchFor
     * @param $arrayKey
     * @param $item
     * @return bool
     */
    protected function key_search_match($keyToSearchFor, $arrayKey, $item) {

        return $keyToSearchFor === $arrayKey;

    }

    /**
     * @return mixed
     */
    public function get_items()
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
    public function is_empty()
    {
        return $this->getLength() === 0;
    }

    /**
     * @param $keyToSearchFor
     * @return bool
     */
    public function key_exists($keyToSearchFor)
    {

        $key_exists = false;

        foreach($this->items AS $key => $item) {

            if($this->key_search_match($keyToSearchFor, $key, $item)) {

                $key_exists = true;
                break;

            }

        }

        return $key_exists;

    }

    /**
     * @param $key
     * @return Collection
     */
    public function remove_item($key)
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
    public function remove_item_by_function_value($functionName, $value)
    {

        foreach ($this->items AS $itemKey => $item) {

            if (method_exists($item, $functionName) && $item->$functionName() === $value) {
                $this->remove_item($itemKey);
            }

        }

        return $this;

    }

}
