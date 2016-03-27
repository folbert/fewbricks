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
    protected $label = 'Demo Flexible Brick';

    /**
     *
     */
    public function set_fields()
    {

        $fc = new acf_fields\flexible_content('Modules', 'modules', '1509111554i');

        $l = new layout('', 'text', '1603250048a');
        $l->add_brick(new demo_headline('headline', '1603250048b'));
        $fc->add_layout($l);

        $l = new layout('', 'headline', '1603250054a');
        $l->add_brick(new demo_text('text', '1603250054b'));
        $fc->add_layout($l);

        $l = new layout('', 'button', '1509111557u');
        $l->add_brick(new demo_button('button', '1509111556s'));
        $fc->add_layout($l);

        $l = new layout('', 'video', '1509111555a');
        $l->add_brick(new demo_video('video', '1509111556x'));
        $fc->add_layout($l);

        $this->add_flexible_content($fc);

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = '';

        while ($this->have_rows('modules')) {

            $this->the_row();

            /** @noinspection PhpUndefinedMethodInspection */
            $html .= acf_fields\flexible_content::get_sub_field_brick_instance()->get_html();

        }

        return $html;

    }

}