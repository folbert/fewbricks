<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class demo_youtube
 * @package fewbricks\bricks
 */
class youtube extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'YouTube';

    /**
     *
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Headline', 'headline', '1504171928i'));

        $this->add_field(
            (new acf_fields\oembed('URL', 'url', '15011143u'))
            ->set_settings([
                'instructions' => 'Enter the URL of the YouTube video that you want to display. The URL should look something like this: https://www.youtube.com/watch?v=wZZ7oFKsKzY .'
            ])
        );

        $this->add_brick((new button('button', '1509042128i'))->set_field_label_prefix('Youtube button'));
        //$this->add_brick((new buttons_list('buttons', '1509062216'))->set_field_label_prefix('Wooo'));

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