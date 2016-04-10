<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class flexible_brick
 * @package fewbricks\bricks
 */
class demo_flexible_columns extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'Demo Flexible Columns';

    /**
     *
     */
    public function set_fields()
    {

        $nr_of_columns = $this->get_arg('nr_of_columns');

        for ($column_nr = 1; $column_nr <= $nr_of_columns; $column_nr++) {

            $this->add_field((new acf_fields\tab('Column ' . $column_nr, 'column_' . $column_nr,
                '1509141033a' . $column_nr)));

            $this->add_brick(new demo_flexible_brick('fb' . $column_nr, '1509141034a' . $column_nr));

        }

        // Lets store the nr of columns in a hidden field
        $this->add_field(new acf_fields\fewbricks_hidden('-', 'nr_of_columns', '1603250004e', [
            'default_value' => $nr_of_columns
        ]));

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $nr_of_columns = $this->get_field('nr_of_columns');

        $column_classes = $this->get_column_classes($nr_of_columns);

        $html = '
        <div class="row">
        ';

        for ($column_nr = 1; $column_nr <= $nr_of_columns; $column_nr++) {

            $html .= '<div class="' . $column_classes . '">';

            $html .= $this->get_child_brick('demo_flexible_brick', 'fb' . $column_nr)->get_html();

            $html .= '</div>';

        }

        $html .= '
        </div>
        ';

        return $html;

    }

    /**
     * @param $nr_of_columns
     * @return string
     */
    private function get_column_classes($nr_of_columns)
    {

        $column_classes = '';

        switch ($nr_of_columns) {

            case '2' :

                $column_classes = 'col-md-6';
                break;

            case '3' :

                $column_classes = 'col-md-4';
                break;

            case '4' :

                $column_classes = 'col-md-3';
                break;

        }

        return $column_classes;

    }

}