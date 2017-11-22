<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;

class Collection
{

    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {

        $this->items = $items;

    }

    /**
     * @param Field $item
     * @param null $key
     */
    public function addItem($item, $key = null)
    {

        if (is_null($key)) {

            $this->items[] = $item;

        } else {

            if (isset($this->items[$key])) {
                throw new KeyHasUseException('Key ' . $key
                                             . ' already in use.');
            } else {
                $this->items[$key] = $obj;
            }

        }

    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getItem($key)
    {
        if (isset($this->items[$key])) {

            return $this->items[$key];

        } else {

            throw new KeyInvalidException('Invalid key ' . $key . '.');

        }
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
    public function getKeys() {
        return array_keys($this->items);
    }

    /**
     * @return int
     */
    public function getLength() {
        return count($this->items);
    }

    /**
     * @param $key
     */
    public function deleteItem($key)
    {

        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }

    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function keyExists($key) {
        return isset($this->items[$key]);
    }

}
