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
     */
    public function addItem($item, $key = null)
    {

        if (is_null($key)) {

            array_push($this->items, $item);

        } else {

            try {

                $this->validateKey($item, $key);
                $this->items[$key] = $item;

            } catch (KeyInUseException $keyInUseException) {

                $keyInUseException->wpDie();

            }

        }

    }

    /**
     * @param Field  $item
     * @param string $keyToAddAfter
     */
    public function addItemAfter($item, $keyToAddAfter)
    {

        if (false !== ($positionToAddAfter = $this->getItemIndex($keyToAddAfter))) {

            $this->items = array_merge(
                array_slice($this->items, 0, ($positionToAddAfter + 1)),
                [$item],
                array_slice($this->items, ($positionToAddAfter + 1))
            );

        }

    }

    /**
     * @param Field  $item
     * @param string $keyToAddBefore
     */
    public function addItemBefore($item, $keyToAddBefore)
    {

        if (false !== ($positionToAddBefore = $this->getItemIndex($keyToAddBefore))) {

            $this->items = array_merge(
                array_slice($this->items, 0, $positionToAddBefore),
                [$item],
                array_slice($this->items, $positionToAddBefore)
            );

        }

    }

    /**
     * @param $item
     */
    public function addItemToBeginning($item)
    {

        array_unshift($this->items, $item);

    }

    /**
     * @param $items
     */
    public function addItemsToBeginning($items)
    {

        array_unshift($this->items, $items);

    }

    /**
     * @param $key
     *
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
     *
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
     * @param $itemAttemptedToAdd
     * @param $keyAttemptedToAdd
     *
     * @return string
     */
    public function getKeyInUseExceptionMessage($itemAttemptedToAdd, $keyAttemptedToAdd)
    {

        $message = '';

        if (method_exists($itemAttemptedToAdd, 'getLabel')) {

            $message .= 'Error when attempting to register the item with the key <code>'
                        . $keyAttemptedToAdd . '</code> and label "' . $itemAttemptedToAdd->getLabel() . '". The key is already
                                            used by an item named "' . $this->items[$keyAttemptedToAdd]->getLabel() . '" and keys must
                                             be unique.';

        } else {

            $message .= 'Error when attempting to register the item with the key ' . $keyAttemptedToAdd;

        }

        $message
            .= '<br><br>Pro-tip: create your keys manually by using the current date and time . So if you
are creating a field at 09:59 on December 11 2017, the key might be "1712110959a" . Note the addition of an extra
character to ensure that ACF can use the key but also to make sure that if you create another key within the same
minute, you can simply append some other "random" letter to that key like "1712110989x"';

        return $message;

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

    public function isEmpty()
    {
        return $this->getLength() === 0;
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
     * @param mixed  $item
     * @param string $key
     *
     * @return bool
     * @throws KeyInUseException
     */
    public function validateKey($item, $key)
    {

        if (isset($this->items[$key])) {

            throw new KeyInUseException($this->getKeyInUseExceptionMessage($item, $key));

        }

        return true;

    }

}
