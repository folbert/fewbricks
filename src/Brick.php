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
     * @param string $name Name to use when fetching data for the brick. Should not be changed later on
     *                     to avoid troubles when fetching data for fields in brick
     * @param string $key  This value must be unique system wide. See the readme-file for tips on how to achieve this.
     *                     Note that it only needs to be set when registering the brick to a field group, layout etc.
     *                     No need to pass it when called from the frontend to print the brick.
     * @param array  $args
     */
    public function __construct($name, $key, $args = [])
    {

        $this->name = $name;
        $this->key  = $key;

        parent::__construct($args);

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
    public function getLabel()
    {

        return $this->label;

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
        return parent::toAcfArray($this->getKey());
    }

}
