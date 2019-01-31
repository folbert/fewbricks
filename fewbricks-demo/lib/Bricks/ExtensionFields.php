<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Extensions\AcfCodeField;
use Fewbricks\ACF\Fields\Extensions\DynamicYearSelect;
use Fewbricks\ACF\Fields\Extensions\Table;

class ExtensionFields extends Brick
{

    /**
     *
     */
    public function set_up()
    {

        if (class_exists('acf_field_dynamic_year_select')) {

            $this->add_field(
                (new DynamicYearSelect('Select a year', 'year', '1812012249a'))
                    ->set_newest_year([
                        'method' => 'relative',
                        'relative_year' => '20',
                    ])
                    ->set_oldest_year([
                        'method' => 'relative',
                        'relative_year' => '2',
                    ]));

        }

        if (class_exists('acf_code_field')) {

            $this->add_field(
                (new AcfCodeField('Code', 'code', '1812012332a'))
                    ->set_mode('application/x-httpd-php')
                    ->set_placeholder('Fill this!')
                    ->set_default_value('<?php')
            );

        }

        if (class_exists('acf_field_dynamic_year_select')) {

            $this->add_field((new Table('Table', 'table', '1812012354a')));

        }

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['text', 'image']);

    }

}
