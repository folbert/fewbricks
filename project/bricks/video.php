<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class video
 * @package fewbricks\bricks
 */
class video extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'Video';

    /**
     *
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Headline', 'headline', '1504171928i'));

        $this->add_field(
            (new acf_fields\oembed('URL', 'url', '15011143u'))
                ->set_settings([
                    'instructions' => 'Enter the URL of the YouTube or Vimeo video that you want to display.'
                ])
        );

        $this->add_brick((new button('button', '1509042128i'))->set_field_label_prefix('Youtube button'));;

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = $this->get_headline_html('headline');


        if (false !== ($url = $this->get_video_url())) {


            $html .= '
              <div class="row">
                  <div class="col-xs-12">
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="' . $url . '" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>';

        }

        //\fewture\vd($this->get_setting('name'));

        if('' !== ($button_html = ($this->get_child_brick('button', 'button')->get_html()))) {

            $html .= $button_html;

        }

        return $html;

    }

    private function get_video_url()
    {

        $url = false;

        preg_match('/src="(.+?)"/', $this->get_field('url'), $matches);

        $url_match = $matches[1];

        if (isset($matches[1])) {

            $params = [];
            $params['showinfo'] = 0;
            $params['modestbranding'] = 1;
            $params['theme'] = 'light';
            $params['rel'] = 0;
            $params['wmode'] = 'transparent';

            if (!empty($params)) {
                $url = add_query_arg($params, $url_match);
            }

        }

        return $url;

    }

}