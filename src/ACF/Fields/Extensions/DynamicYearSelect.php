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
     * @param $currentYear array with indexes 'allow' (boolean) and 'current' which should hold the text to display for
     * current year in the select box.
     * @return $this
     */
    public function set_current_year(array $currentYear)
    {

        // Make sure all indexes are set.
        $currentYear = array_merge([
            'allow' => false,
            'label' => 'Current',
        ], $currentYear);

        return $this->set_setting('current_year', $currentYear);

    }

    /**
     * @param array $newestYear
     * @return $this
     */
    public function set_newest_year(array $newestYear)
    {

        $newestYear = array_merge([
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after',
        ], $newestYear);

        return $this->set_setting('newest_year', $newestYear);

    }

    /**
     * @param array $oldestYear
     * @return $this
     */
    public function set_oldest_year(array $oldestYear)
    {

        $oldestYear = array_merge([
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ], $oldestYear);

        return $this->set_setting('oldest_year', $oldestYear);

    }

    /**
     * @param $orderBy 'chronological' or 'rchronological' for reversed chronological.
     * @return $this
     */
    public function set_order_by($orderBy)
    {

        return $this->set_setting('order_by', $orderBy);

    }

    /**
     * @param $yearStep
     * @return $this
     */
    public function set_year_step($yearStep)
    {

        return $this->set_setting('year_step', $yearStep);

    }

    /**
     * @return array
     */
    public function get_current_year()
    {

        $defaultValue = [
            'allow' => false,
            'label' => 'Current',
        ];

        return $this->get_setting('current_year', $defaultValue);

    }

    /**
     * @return array
     */
    public function get_newest_year()
    {

        $defaultValue = [
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after'
        ];

        return $this->get_setting('newest_year', $defaultValue);

    }

    /**
     * @return array
     */
    public function get_oldest_year()
    {

        $defaultValue = [
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ];

        return $this->get_setting('oldest_year', $defaultValue);

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
