<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;
use fewbricks\acf\layout;

/**
 * Class demo_youtube
 * @package fewbricks\bricks
 */
class flexible_brick extends project_brick
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

        $fc = new acf_fields\flexible_content('Flexible content', 'fc', '1509062208a');

        $l = new layout('Flexible content', 'l6', '1509062306a');
        $fc2 = new acf_fields\flexible_content('Flexible content2', 'fc2', '1509062307tf');
        $l2 = new layout('', 'l1', '1509062210uf');
        $l2->add_brick((new youtube('youtube', '1509062211of'))->set_label('Youtube?'));
        $fc2->add_layout($l2);
        $l2 = new layout('', 'l2', '1509062210ui');
        $l2->add_brick((new youtube('youtube', '1509062211oi'))->set_label('Youtubeooo'));
        $fc2->add_layout($l2);
        $l->add_flexible_content($fc2);
        $fc->add_layout($l);

        $l = new layout('', 'l1', '1509062210u');
        $l->add_brick((new youtube('youtube', '1509062211o'))->set_label('Youtube?'));
        $fc->add_layout($l);

        $l = new layout('Field test', 'l3', '1509062210x');
        $l->add_sub_field(new acf_fields\text('Some text in FC', 'text', '1509062245'));
        $l->add_sub_field(new acf_fields\text('Some more text in FC', 'more_text', '1509062245x'));
        $fc->add_layout($l);

        $l = new layout('', 'l2', '1509062210y');
        $l->add_brick((new youtube('youtube', '1509062211p'))->set_label('Youtube??'));
        $fc->add_layout($l);

        $l = new layout('Buttons', 'l4', '1509062210l');
        $l->add_repeater(
            (new acf_fields\repeater('Buttonssss', 'buttons', '1509052323a'))
                ->add_brick(new button('button', '15092323u'))
                ->add_repeater(
                    (new acf_fields\repeater('Subx repeater', 'sup_rep', '1509062035t'))
                        ->add_sub_field(new acf_fields\text('Sub repeater text', 'txt', '1509062036y'))
                )
        );
        $fc->add_layout($l);

        $this->add_flexible_content($fc);

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = $this->get_headline_html('headline');

        preg_match('/src="(.+?)"/', $this->get_data_value('url'), $matches);

        if (isset($matches[1])) {

            $url = $matches[1];

            $params = [];
            $params['showinfo'] = 0;
            $params['modestbranding'] = 1;
            $params['theme'] = 'light';
            $params['rel'] = 0;
            $params['wmode'] = 'transparent';

            if (!empty($params)) {
                $url = add_query_arg($params, $url);
            }

            $html .= '
              <div class="row">
                  <div class="col-xs-12">
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="' . $url . '" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>';

        }

        return $html;

    }

}