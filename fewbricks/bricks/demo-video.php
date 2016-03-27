<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class video
 * @package fewbricks\bricks
 */
class demo_video extends project_brick
{

    /**
     * @var string
     */
    protected $label = 'Demo Video';

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

        $this->add_brick((new demo_button('button', '1509042128i'))->set_field_label_prefix('Youtube button'));

        if (!isset($this->args['no_bg_color']) || !$this->args['no_bg_color']) {
            $this->add_common_field('demo_background_color', '1509112010i');
        }

    }

    /**
     * @return string
     */
    protected function get_brick_html()
    {

        $html = $this->demo_get_headline_html('headline');

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

        if ('' !== ($button_html = ($this->get_child_brick('demo_button', 'button')->get_html()))) {

            $html .= $button_html;

        }

        return $html;

    }

    /**
     * Function to show what Twig could do for you
     * @return string
     */
    /*
    protected function get_brick_html()
    {

        $data = [
            'headline' => $this->demo_get_headline_html('headline'),
            'url' => $this->get_video_url(),
            'button_html' => $this->get_child_brick('demo_button', 'button')->get_html()
        ];

        return \Timber::compile('demo-video.twig', $data);

    }
    */

    /**
     * @return bool|mixed|null|void
     */
    private function get_video_url()
    {

        $url = $this->get_field('url');

        if (!empty($url)) {

            preg_match('/src="(.+?)"/', $this->get_field('url'), $matches);

            if (isset($matches[1])) {

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

            }

        }

        return (empty($url) ? false : $url);

    }

}