<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class demo_buttons_list extends project_brick
{

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Demo Buttons list';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Buttons list headline', 'headline', '1509052316y'));

        $this->add_repeater((new acf_fields\repeater('Buttons', 'buttons', '1509052323a', [
            'button_label' => 'Add button'
        ]))
            ->add_brick(new demo_button('button', '1509111350i')));

        if (!isset($this->args['no_bg_color']) || !$this->args['no_bg_color']) {
            $this->add_common_field('demo_background_color', '1509112010i');
        }

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = '
          <div class="row">
            <div class="col-xs-12">
                <h2>' . $this->get_field('headline') . '</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
                <ul>';

        if ($this->have_rows('buttons')) {

            while ($this->have_rows('buttons')) {

                $this->the_row();

                $html .= '<li>' . $this->get_child_brick_in_repeater('buttons', 'button', 'demo_button')->get_html() . '</li>';

            }

        }

        $html .= '
              </ul>
            </div>
          </div> <!-- /.row -->
        ';

        return $html;

    }

}