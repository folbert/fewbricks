<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class buttons_list extends project_brick {

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Buttons list';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Buttons list headline', 'headline', '1509052316y'));
        $this->add_repeater(new acf_fields\repeater('Buttons', 'buttons', '1509052323a'));

    }

    /**
     * @param array $args
     * @return string
     */
    public function get_html($args = [])
    {

        $html = '
          <div class="row">
            <h2>' . $this->get_field() . '</h2>
          </div>
        ';

        return $html;

    }

}