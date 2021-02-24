<?php

// Make sure to set your own namespace here
namespace Fewbricks\ACF\Fields\Extensions;

use Fewbricks\ACF\Field;

// Replace NameOfField with CamelCase version of the value of TYPE below.
class DynamicYearSelect extends Field
{

    // Check the v5-file in the extensions plugin folder and copy the value for
    // $this->name and replace name_of_field below with that value. Yes, a constant named TYPE
    // is set to the name of the field. Seems wrong but it is not.
    const TYPE = 'dynamic_year_select';

    /**
     * Taking care of the above is really all you have to do to have the field type up and running. But do yourself a
     * favour and add setters and getters for the field types settings below.
     */

    /**
     * 'year_step'                => 1,
     * 'order_by' => 'chronological',
     * 'current_year' => array(
     *  'allow' => false,
     *  'label' => 'Current'
     * ),
     * 'oldest_year'            => array(
     *  'method'        => 'relative',
     *  'exact_year'    => date('Y'),
     *  'relative_year' => 20,
     *  'relative_year_direction' => 'before'
     * ),
     * 'newest_year'            => array(
     *  'method'        => 'exact',
     *  'exact_year'    => date('Y'),
     *  'relative_year' => 20,
     *  'relative_year_direction' => 'after'
     * )
     */

    /**
     * @param $current_year array with indexes 'allow' (boolean) and 'current' which should hold the text to display for
     * current year in the select box.
     * @return $this
     */
    public function set_current_year(array $current_year)
    {

        // Make sure all indexes are set.
        $current_year = array_merge([
            'allow' => false,
            'label' => 'Current',
        ], $current_year);

        return $this->set_setting('current_year', $current_year);

    }

    /**
     * @param array $newest_year
     * @return $this
     */
    public function set_newest_year(array $newest_year)
    {

        $newest_year = array_merge([
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after',
        ], $newest_year);

        return $this->set_setting('newest_year', $newest_year);

    }

    /**
     * @param array $oldest_year
     * @return $this
     */
    public function set_oldest_year(array $oldest_year)
    {

        $oldest_year = array_merge([
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ], $oldest_year);

        return $this->set_setting('oldest_year', $oldest_year);

    }

    /**
     * @param $order_by 'chronological' or 'rchronological' for reversed chronological.
     * @return $this
     */
    public function set_order_by($order_by)
    {

        return $this->set_setting('order_by', $order_by);

    }

    /**
     * @param $year_step
     * @return $this
     */
    public function set_year_step($year_step)
    {

        return $this->set_setting('year_step', $year_step);

    }

    /**
     * @return array
     */
    public function get_current_year()
    {

        $default_value = [
            'allow' => false,
            'label' => 'Current',
        ];

        return $this->get_setting('current_year', $default_value);

    }

    /**
     * @return array
     */
    public function get_newest_year()
    {

        $default_value = [
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after'
        ];

        return $this->get_setting('newest_year', $default_value);

    }

    /**
     * @return array
     */
    public function get_oldest_year()
    {

        $default_value = [
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ];

        return $this->get_setting('oldest_year', $default_value);

    }

    /**
     * @return int
     */
    public function get_order_by()
    {

        return $this->get_setting('order_by', 'chronological');

    }

    /**
     * @return int
     */
    public function get_year_step()
    {

        return $this->get_setting('year_step', 1);

    }

}
