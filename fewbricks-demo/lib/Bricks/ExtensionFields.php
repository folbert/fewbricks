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
    public function setUp()
    {

        if (class_exists('acf_field_dynamic_year_select')) {

            $this->addField(
                (new DynamicYearSelect('Select a year', 'year', '1812012249a'))
                    ->setNewestYear([
                        'method' => 'relative',
                        'relative_year' => '20',
                    ])
                    ->setOldestYear([
                        'method' => 'relative',
                        'relative_year' => '2',
                    ]));

        }

        if (class_exists('acf_code_field')) {

            $this->addField(
                (new AcfCodeField('Code', 'code', '1812012332a'))
                    ->setMode('application/x-httpd-php')
                    ->setPlaceholder('Fill this!')
                    ->setDefaultValue('<?php')
            );

        }

        if (class_exists('acf_field_dynamic_year_select')) {

            $this->addField((new Table('Table', 'table', '1812012354a')));

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
