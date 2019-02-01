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
     * @param string $key_to_add_after
     * @param null|string $key_of_new_item
     * @return $this
     */
    public function add_item_after_item_by_key($item, string $key_to_add_after, $key_of_new_item = null)
    {

        if (false !== ($position_to_add_after = $this->get_position_for_item_by_key($key_to_add_after))) {

            $this->finalize_item($item);
            $this->validate_item($item);

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
     * @param null|string $key_of_new_item
     * @return $this
     */
    public function add_item_before_item_by_key($item, string $key_of_field_to_add_before, $key_of_new_item = null)
    {

        if (false !== ($position_to_add_before = $this->get_position_for_item_by_key($key_of_field_to_add_before))) {

            $this->finalize_item($item);
            $this->validate_item($item);

            if (is_null($key_of_new_item)) {
                $new_item = [$item];
            } else {
                $new_item = [$key_of_new_item => $item];
            }

            $this->items = array_merge(
                array_slice($this->items, 0, $position_to_add_before),
                $new_item,
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
    public function add_item_to_beginning($item, $key_of_new_item = false)
    {

        $this->finalize_item($item);
        $this->validate_item($item);

        if ($key_of_new_item === false) {

            array_unshift($this->items, $item);

        } else {

            $this->items = array_merge([$key_of_new_item => $item], $this->items);

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
     * @param $key_to_search_for
     * @return mixed
     */
    public function get_item_by_key(string $key_to_search_for)
    {

        $found_item = false;

        foreach($this->items AS $key => $item) {

            if($this->key_search_match($key_to_search_for, $key, $item)) {

                $found_item = $item;
                break;

            }

        }

        return $found_item;

    }

    /**
     * @param string $key_to_search_for
     * @return bool|int
     */
    public function get_position_for_item_by_key(string $key_to_search_for)
    {

        $position = false;

        $position_tracker = 0;

        foreach ($this->items AS $key => $item) {

            if ($this->key_search_match($key_to_search_for, $key, $item)) {

                $position = $position_tracker;
                break;

            }

            $position_tracker++;

        }

        return $position;

    }

    /**
     * @param $key_to_search_for
     * @param $array_key
     * @param $item
     * @return bool
     */
    protected function key_search_match($key_to_search_for, $array_key, $item) {

        return $key_to_search_for === $array_key;

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
     * @param $key_to_search_for
     * @return bool
     */
    public function key_exists($key_to_search_for)
    {

        $key_exists = false;

        foreach($this->items AS $key => $item) {

            if($this->key_search_match($key_to_search_for, $key, $item)) {

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
     * @param string $function_name
     * @param mixed $value
     * @return $this
     */
    public function remove_item_by_function_value($function_name, $value)
    {

        foreach ($this->items AS $item_key => $item) {

            if (method_exists($item, $function_name) && $item->$function_name() === $value) {
                $this->remove_item($item_key);
            }

        }

        return $this;

    }

}
