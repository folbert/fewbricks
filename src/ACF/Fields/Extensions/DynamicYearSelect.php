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
     * 'allow' => false,
     * 'label' => 'Current'
     * ),
     * 'oldest_year'            => array(
     * 'method'        => 'relative',
     * 'exact_year'    => date('Y'),
     * 'relative_year' => 20,
     * 'relative_year_direction' => 'before'
     * ),
     * 'newest_year'            => array(
     * 'method'        => 'exact',
     * 'exact_year'    => date('Y'),
     * 'relative_year' => 20,
     * 'relative_year_direction' => 'after'
     * )
     */

    /**
     * @param $currentYear array with indexes 'allow' (boolean) and 'current' which should hold the text to display for
     * current year in the select box.
     * @return $this
     */
    public function setCurrentYear(array $currentYear)
    {

        // Make sure all indexes are set.
        $currentYear = array_merge([
            'allow' => false,
            'current' => 'Current',
        ], $currentYear);

        return $this->setSetting('current_year', $currentYear);

    }

    /**
     * @param array $newestYear
     * @return $this
     */
    public function setNewestYear(array $newestYear)
    {

        $newestYear = array_merge([
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after',
        ], $newestYear);

        return $this->setSetting('newest_year', $newestYear);

    }

    /**
     * @param array $oldestYear
     * @return $this
     */
    public function setOldestYear(array $oldestYear)
    {

        $oldestYear = array_merge([
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ], $oldestYear);

        return $this->setSetting('oldest_year', $oldestYear);

    }

    /**
     * @param $orderBy 'chronological' or 'rchronological' for reversed chronological.
     * @return $this
     */
    public function setOrderBy($orderBy)
    {

        return $this->setSetting('order_by', $orderBy);

    }

    /**
     * @param $yearStep
     * @return $this
     */
    public function setYearStep($yearStep)
    {

        return $this->setSetting('year_step', $yearStep);

    }

    /**
     * @return array
     */
    public function getCurrentYear()
    {

        $defaultValue = [
            'allow' => false,
            'label' => 'Current',
        ];

        return $this->getSetting('current_year', $defaultValue);

    }

    /**
     * @return array
     */
    public function getNewestYear()
    {

        $defaultValue = [
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after'
        ];

        return $this->getSetting('newest_year', $defaultValue);

    }

    /**
     * @return array
     */
    public function getOldestYear()
    {

        $defaultValue = [
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ];

        return $this->getSetting('oldest_year', $defaultValue);

    }

    /**
     * @return int
     */
    public function getOrderBy()
    {

        return $this->getSetting('order_by', 'chronological');

    }

    /**
     * @return int
     */
    public function getYearStep()
    {

        return $this->getSetting('year_step', 1);

    }

}
