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
    public function setup()
    {

        if (is_plugin_active('acf-dynamic-year-select-field/acf-dynamic_year_select.php')) {

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

        if (is_plugin_active('acf-code-field/acf-code-field.php')) {

            $this->addField(
                (new AcfCodeField('Code', 'code', '1812012332a'))
                    ->setMode('application/x-httpd-php')
                    ->setPlaceholder('Fill this!')
                    ->setDefaultValue('<?php')
            );

        }

        if (is_plugin_active('advanced-custom-fields-table-field/acf-table.php')) {

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
