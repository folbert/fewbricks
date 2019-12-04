<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldCollection;
use Fewbricks\ACF\Fields\Extensions\FewbricksHidden;
use Fewbricks\ACF\RuleGroupCollection;

/**
 * Class Brick
 *
 * @package Fewbricks
 */
abstract class Brick extends FieldCollection implements BrickInterface
{

    // FIBC = Fewbricks Internal Brick Class Name and then some random letters to avoid collisions
    const BRICK_CLASS_FIELD_NAME = 'fibcn_7tigo8y9';

    /**
     *
     */
    const CLASS_ID_STRING = 'brick';

    /**
     * @var RuleGroupCollection
     */
    private $conditional_logic_rule_groups;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var boolean
     * @todo Describe this. It can be sued to make a brick live outside of a loop. Check LinkGroup for example.
     */
    protected $detached_from_acf_loop;

    /**
     * @var boolean
     */
    protected $have_brick_class_field;

    /**
     * @var bool True if the brick is a layout for flexible content
     */
    protected $is_layout;

    /**
     * @var bool True if the brick belongs to an ACF options page.
     */
    protected $is_option;

    /**
     * @var bool True if the brick is a sub field for a repeater
     */
    protected $is_sub_field;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var int What post id we should get field from.
     */
    private $post_id_to_get_field_from;

    /**
     * @param string $key This value must be unique system wide. See the documentation for more info on this.
     * Note that it only needs to be set when registering the brick to a field group, layout etc. There's no need to
     * pass it when called from the frontend to print the brick.
     * @param string|boolean $name Name to use when fetching data for the brick. Set to false to use constant NAME
     * @param array $arguments Arbitrary arguments you want to pass to a brick instance to be used within your brick
     * class. This base class does not take any of those arguments into consideration.
     */
    public function __construct(string $key = '', $name = false, array $arguments = [])
    {

        $this->data = [];
        $this->is_layout = false;
        $this->is_option = false;
        $this->is_sub_field = false;
        $this->post_id_to_get_field_from = false;
        $this->have_brick_class_field = false;
        $this->detached_from_acf_loop = false;

        // const NAME was used in early stages of beta so we still have to check it.
        // The constant is now deprecated and "protected $name" should be sued in bricks instead
        if ($name === false && defined('static::NAME')) {
            $this->name = static::NAME;
        } else if($name !== false) {
            $this->name = $name;
        }

        $this->clear_conditional_logic();

        parent::__construct($key, $arguments);

        $this->add_brick_class_field();

    }

    /**
     *
     */
    private function add_brick_class_field()
    {

        if($this->have_brick_class_field) {
            return;
        }

        // We need a way to find out which brick class to load when using it in, for example,  a layout
        $brick_class_field = new FewbricksHidden('Fewbricks Internal - Brick class', self::BRICK_CLASS_FIELD_NAME, 'as3687117858hd89to');
        $brick_class_field->set_default_value(get_class($this));
        $this->add_field($brick_class_field);

        $this->have_brick_class_field = true;

    }

    /**
     * @return $this
     */
    public function clear_conditional_logic()
    {

        $this->conditional_logic_rule_groups = new RuleGroupCollection();

        return $this;

    }

    /**
     * @param Field $item
     */
    protected function finalize_item($item)
    {

        $item->add_parent($this->get_key(), $this->get_name(), self::CLASS_ID_STRING);

    }

    /**
     * @return string
     */
    public function get_name()
    {

        return $this->name;

    }

    /**
     * @param ConditionalLogicRuleGroup[] $rule_groups
     * @return $this
     */
    public function add_conditional_logic_rule_groups($rule_groups)
    {

        foreach ($rule_groups AS $rule_group) {

            $this->add_conditional_logic_rule_group($rule_group);

        }

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup $rule_group
     * @return $this
     */
    public function add_conditional_logic_rule_group($rule_group)
    {

        $this->conditional_logic_rule_groups->add_item($rule_group);

        return $this;

    }

    /**
     * Returns an instance of a brick that belongs to the current brick. This function takes care of passing its own
     * name and whether it is a layout, sub field or option down to the new instance. You can override if the child
     * should be a layout, sub field or option by passing any of the arguments to this function.
     *
     * @param string $class_name
     * @param string $brick_name
     * @param bool $is_layout If the child brick is a layout.
     * @param bool $is_sub_field If the child brick is a sub field
     * @param bool $is_option If the child brick is an option. All field swill be fetched using ACFs "option"
     * argument.
     *
     * @return object An instance of the class passed as $className with the name of $brick_name prepended with the
     * name of the current brick.
     */
    public function get_child_brick(string $class_name = '', string $brick_name = '', bool $is_layout = false,
                                    bool $is_sub_field = false, bool $is_option = false)
    {

        if(empty($class_name)) {
            $row_layout = get_row_layout();
            $class_name = get_sub_field($row_layout . '_' . \Fewbricks\Brick::BRICK_CLASS_FIELD_NAME);
        }

        /** @var Brick $brick_instance */
        $brick_instance = new $class_name('', $brick_name);

        $brick_instance->set_is_layout($this->is_layout);
        $brick_instance->set_is_sub_field($this->is_sub_field);
        $brick_instance->set_is_option($this->is_option);

        // If no special case has been forced on the function call...
        if ($is_layout === false && $is_sub_field === false && $is_option === false) {

            /*// ...let the calling (parent) object decide
            $is_layout = $this->is_layout;
            $is_sub_field = $this->is_sub_field;
            $is_option = $this->is_option;*/
            //$brick_name = $this->name . '_' . $brick_name;

        }

        return $brick_instance;

    }

    /**
     * @return array|bool
     */
    public function get_data()
    {

        return $this->data;

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return [];

    }

    /**
     * @param array $data
     * @return $this
     */
    public function set_data(array $data)
    {

        $this->data = $data;

        return $this;

    }

    /**
     * Get multiple field values in one function call. Pass an array where each item can be either:
     * - a field name
     * - an array where the index is the field name and the value is the name you want to store the value as
     * in in the returned array: ['field_name_1', 'field_name_2', ['field_name_3' => 'name_to_save_as']]
     * Does not support passing extra arguments to get_field_value().
     *
     * @param array $field_names
     *
     * @return array
     */
    public function get_field_values(array $field_names)
    {

        $values = [];

        foreach ($field_names AS $field_name) {

            if (is_array($field_name)) {

                $key = key($field_name);
                $values[$field_name[$key]] = $this->get_field_value($key);

            } else {

                $values[$field_name] = $this->get_field_value($field_name);

            }
        }

        return $values;

    }

    /**
     * @param string $field_name The first parameter to pass to ACFs get_field-function. This value may be changed
     * inside the function depending on the values of other parameters.
     * @param bool $post_id Second parameter to pass to ACFs get_field-function
     * @param bool $format_value Third parameter to pass to ACFs get_field-function
     * @param bool $prepend_current_objects_name If the current objects name should be prepended to $data_name
     * @param bool $get_from_sub_field
     *
     * @return bool|mixed|null
     *
     * @link https://www.advancedcustomfields.com/resources/get_sub_field/
     * @link https://www.advancedcustomfields.com/resources/get_field/
     */
    public function get_field_value(string $field_name, $post_id = false, $format_value = true,
                                       bool $prepend_current_objects_name = true, bool $get_from_sub_field = false
    )
    {

        if ($prepend_current_objects_name) {

            if (substr($field_name, 0, 1) !== '_') {
                $field_name = '_' . $field_name;
            }

            $name = $this->name . $field_name;

        } else {

            $name = $field_name;

        }

        $name = $this->field_names_prefix . $name;

        if ($post_id === false && $this->post_id_to_get_field_from !== false) {
            $post_id = $this->post_id_to_get_field_from;
        }

        $data_value = null;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $data_value = $this->data[$name];

        } else if ($post_id === false && ($get_from_sub_field || $this->is_layout || $this->is_sub_field)) {

            $data_value = $this->get_field_value_from_sub_field($name, $format_value);

            // We should get data using acf functions and we are dealing with layout or sub field

        } else {
            // ACF data which is not a layout or sub field

            if ($this->is_option === true) {

                if (null !== ($value = get_field($name, 'options', $format_value))) {

                    $data_value = $value;

                }

            } else if (null !== ($value = get_field($name, $post_id, $format_value))) {

                $data_value = $value;

            }

        }

        return $data_value;

    }

    /**
     * @param $name
     * @param $format_value
     * @return bool|null
     */
    public function get_field_value_from_sub_field($name, $format_value)
    {

        $data_value = null;

        // Is it an ACF option?
        // get_sub_field can not deal with "option". Error in fewbricks 1
        if ($this->is_option === true) {

            if (null !== ($value = get_sub_field($name, 'options'))) {

                $data_value = $value;

            }

        } else {
            // Not ACF option

            if (!is_null($value = get_sub_field($name, $format_value))) {

                $data_value = $value;

            }

        }

        return $data_value;

    }

    /**
     *
     */
    public function detach_from_acf_loop()
    {

        if($this->detached_from_acf_loop) {
            return;
        }

        $active_loop = acf_get_loop('active');

        if(!$active_loop) {
            return;
        }

        $this->set_field_names_prefix($active_loop['name'] . '_' . $active_loop['i'] . '_');
        $this->set_is_layout(false);
        $this->detached_from_acf_loop = true;

    }

    /**
     * @return bool
     */
    public function get_is_layout()
    {

        return $this->is_layout;

    }

    /**
     * @param $is_layout
     * @return $this
     */
    public function set_is_layout($is_layout)
    {

        $this->is_layout = $is_layout;

        return $this;

    }

    /**
     * @return bool
     */
    public function get_is_option()
    {

        return $this->is_option;

    }

    /**
     * @param $is_option
     * @return $this
     */
    public function set_is_option($is_option)
    {

        $this->is_option = $is_option;

        return $this;

    }

    /**
     * @return bool
     */
    public function get_is_sub_field()
    {

        return $this->is_sub_field;

    }

    /**
     * @param $is_sub_field
     *
     * @return $this
     */
    public function set_is_sub_field($is_sub_field)
    {

        $this->is_sub_field = $is_sub_field;

        return $this;

    }

    /**
     * @return mixed
     */
    public function get_post_id_to_get_field_from()
    {

        return $this->post_id_to_get_field_from;

    }

    /**
     * Set a value that should be passed as the second argument to ACFs get_field.
     * Note that it can also be options, taxonomies, users etc. For more info, see "Get a value from different
     * objects" at the link below.
     *
     * @link http://www.advancedcustomfields.com/resources/get_field/
     *
     * @param $postId
     * @return $this
     */
    public function set_post_id_to_get_field_from($postId)
    {

        $this->post_id_to_get_field_from = $postId;

        return $this;

    }

    /**
     * Checks if the brick has a layout with the name that you pass to the function. Returns true if it does, false if
     * not.
     *
     * @param string $brickLayoutName
     *
     * @return boolean True if the brick has a layout with the passed name, false if not.
     */
    /*public function has_brick_layout($brick_layout_name)
    {

        return in_array($brick_layout_name, $this->brick_layouts);

    }*/

    /**
     * Use this to set custom data for the brick.
     *
     * @param string $item_name The name of the item.
     * @param mixed $value The value of the item.
     * @param bool $auto_prefix_brick_name Set to true to have the name of the brick be prepended to $field_name
     * @param bool $group_name Use this if you want to create groups of data.
     * @return $this
     */
    public function add_data_item($item_name, $value, $auto_prefix_brick_name = true, $group_name = false)
    {

        if($auto_prefix_brick_name) {
            $item_name = $this->name . '_' . $item_name;
        }

        if ($group_name === false) {

            $this->data[$item_name] = $value;

        } else {

            $this->data[$group_name][$item_name] = $value;

        }

        return $this;

    }

    /**
     * Use this to set custom data for the brick.
     *
     * @param array $names_and_values
     * @param bool $auto_prefix_brick_name Set to true to have the name of the brick be prepended to $field_name
     * @param bool $group_name Use this if you want to create groups of data.
     * @return $this
     */
    public function add_data_items($names_and_values, $auto_prefix_brick_name = true, $group_name = false)
    {

        foreach($names_and_values AS $name => $value) {

            $this->add_data_item($name, $value, $auto_prefix_brick_name, $group_name);

        }

        return $this;

    }

    /**
     * This function, which is empty on purpose, will automatically be called when instantiating a brick class. You can
     * uses this fact by overriding it in your own Brick classes and adding code for adding your own fields or bricks
     * or whatever you want.
     */
    public function set_up()
    {

    }

    /**
     *
     */
    protected function prepare_for_acf_array()
    {

        if(!$this->prepared_for_acf_array) {

            if (!$this->conditional_logic_rule_groups->is_empty()) {

                foreach ($this->items AS $field_index => $field) {

                    foreach ($this->conditional_logic_rule_groups->get_items() AS $conditional_logic_rule_group) {

                        $this->items[$field_index]->add_conditional_logic_rule_group($conditional_logic_rule_group);

                    }

                }

            }

            parent::prepare_for_acf_array();

        }

    }

    /**
     * Wrapper function for ACFs have_rows()
     * @param $name
     * @param bool $post_id Specific post ID where your value was entered.
     * Defaults to current post ID (not required). This can also be options / taxonomies / users / etc
     * See https://www.advancedcustomfields.com/resources/have_rows/
     * @return bool
     */
    protected function have_rows($name, $post_id = false)
    {

        if($post_id !== false) {
            $outcome = have_rows($this->name . '_' . $name, $post_id);
        } elseif ($this->is_option) {
            $outcome = have_rows($this->name . '_' . $name, 'option');
        } else {
            $outcome = have_rows($this->name . '_' . $name);
        }

        return $outcome;

    }

    /**
     * Wrapper function for ACFs the_row to avoid confusion on when to use $this or not for ACF functions.
     */
    protected function the_row()
    {

        the_row();

    }

    /**
     * @param $label
     */
    public function set_label($label)
    {

        $this->label = $label;

    }

    /**
     * @return string
     */
    public function get_label()
    {

        return $this->label;

    }

}
