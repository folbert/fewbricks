<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;
use fewbricks\acf\layout;

/**
 * Class flexible_brick
 * @package fewbricks\bricks
 */
class demo_flexible_brick extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'Flexible Brick';

    /**
     *
     */
    public function set_fields()
    {

        $fc = new acf_fields\flexible_content('Modulez', 'modules', '1509111554i');

        $l = new layout('', 'l1', '1509111555a');
        $l->add_brick(new demo_video('video', '1509111556x'));
        $fc->add_layout($l);

        $l = new layout('', 'l2', '1509111557u');
        $l->add_brick(new demo_button('button', '1509111556s'));
        $fc->add_layout($l);

        $this->add_flexible_content($fc);

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = '';

        while ($this->have_rows('modules') ) {

            $this->the_row();

            echo acf_fields\flexible_content::get_sub_field_brick_instance()->get_html();

        }

        return $html;

    }

}