<?php

namespace Fewbricks;

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
     *
     * @param array $items
     */
    public function __construct($items = [])
    {

        $this->items = $items;

    }

    /**
     * @param mixed $item
     * @param null  $key
     *
     * @throws KeyInUseException
     */
    public function addItem($item, $key = null)
    {

        if (is_null($key)) {

            array_push($this->items, $item);

        } else {

            if (isset($this->items[$key])) {

                throw new KeyInUseException('Key <code>' . $key . '</code> already in use. Keys must be 
unique.<br><br>Pro-tip: create your keys manually 
by using the current date and time. So if you are creating a field at 09:59 on December 11 2017, the key might be "1712110959a". Note the addition of an extra character to ensure that ACF can use the key but also to make sure that if you create another key within the same minute, you can simply append some other "random" letter to that key like "1712110989x".');

            } else {

                $this->items[$key] = $item;

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
    public function getKeys()
    {
        return array_keys($this->items);
    }

    public function isEmpty()
    {
        return $this->getLength() === 0;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @param $key
     */
    public function removeItem($key)
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
    public function keyExists($key)
    {
        return isset($this->items[$key]);
    }

}
