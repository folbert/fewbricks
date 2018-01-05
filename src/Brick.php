<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldCollection;

/**
 * Class Brick
 *
 * @package Fewbricks
 */
class Brick extends FieldCollection implements BrickInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    private $key;

    /**
     * Brick constructor.
     *
     * @param string $name      Name to use when fetching data for the brick.
     * @param string $key       This value must be unique system wide. See the readme-file for tips on how to achieve this.
     *                          Note that it only needs to be set when registering the brick to a field group, layout etc.
     *                          No need to pass it when called from the frontend to print the brick.
     * @param array  $arguments Arbitrary arguments you want to pass to a brick instance to be used within the brick.
     */
    public function __construct($name, $key, $arguments = [])
    {

        $this->name = $name;
        $this->key  = $key;

        parent::__construct($arguments);

    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {

        $field->prefixKey($this->getKey() . '_');
        $field->prefixName($this->getName() . '_');

        parent::addField($field);

    }

    /**
     * @return string
     */
    public function getBaseKey()
    {

        return $this->getKey();

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->name;

    }

    /**
     *
     */
    public function setFields()
    {

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {
        return parent::toAcfArray();
    }

}
