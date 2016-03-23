<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class demo_standard_list extends project_brick
{

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Demo List';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('List headline', 'list_headline', '1509052105r'));

        $this->add_common_field('demo_background_color', '1509052128y');

        $this->add_repeater((new acf_fields\repeater('Items', 'list_items', '1509052105s'))
            ->add_sub_field(new acf_fields\text('Item headline', 'list_item_headline', '1509072209i'))
            ->add_sub_field(new acf_fields\textarea('Item text', 'list_item_text', '1509052124u')));

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = '
          <div class="row">
            <div class="col-xs-12">
                <h2>' . $this->get_field('list_headline') . '</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">';

        if ($this->have_rows('list_items')) {

            while ($this->have_rows('list_items')) {

                $this->the_row();

                $html .= '<li>';
                $html .= '<h3>' . $this->get_field_in_repeater('list_items', 'list_item_headline') . '</h3>';
                $html .= $this->get_field_in_repeater('list_items', 'list_item_text');
                $html .= '</li>';

            }

        }

        $html .= '
            </div>
          </div> <!-- /.row -->
        ';

        return $html;

    }

}