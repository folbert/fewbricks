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

        $this->add_field(new acf_fields\text('A Headline', 'headline', '1509052316y'));

        $this->add_repeater(
            (new acf_fields\repeater('Buttons', 'buttons', '1509052323a'))
                ->add_brick(new button('button', '15092323u'))
                ->add_repeater(
                    (new acf_fields\repeater('Sub repeater', 'sup_rep', '1509062035t'))
                        ->add_sub_field(new acf_fields\text('Sub repeater text', 'txt', '1509062036y'))
                )
        );

        $this->add_brick(new flexible_brick('flexbrick', '1509062243r'));
        $this->add_brick((new flexible_brick('flexbrick2', '1509062243s'))->set_field_label_prefix('APA!!!'));

    }

    /**
     * @param array $args
     * @return string
     */
    public function get_html($args = [])
    {

        return '';

    }

}