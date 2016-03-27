<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class demo_button extends project_brick
{

    private $css_class = false;

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Demo Button';

    /**
     * This is where all the fields for the brick will be set.
     */
    public function set_fields()
    {

        $this->add_field((new acf_fields\select('Type', 'type', '1509032104a'))
            ->set_settings([
                'choices' => [
                    'internal' => 'Internal',
                    'external' => 'External',
                    'email' => 'E-mail',
                    'download' => 'Download'
                ],
                'allow_null' => 'false',
                'default_value' => 'internal'
            ])
        );

        $this->add_field(new acf_fields\text('Text', 'text', '1509072239o'));

        $this->add_field(
            (new acf_fields\post_object('Item', 'internal_item', '1509032109u'))->set_setting('conditional_logic',
                [
                    [
                        [
                            'field' => '1509032104a',
                            'operator' => '==',
                            'value' => 'internal',
                        ],
                    ]
                ]
            ));

        $this->add_field(
            (new acf_fields\url('URL', 'external_url', '1509032109r'))->set_setting('conditional_logic',
                [
                    [
                        [
                            'field' => '1509032104a',
                            'operator' => '==',
                            'value' => 'external',
                        ],
                    ]
                ]
            ));

        $this->add_field((new acf_fields\email('E-mail', 'email', '1509032109s'))->set_setting('conditional_logic',
            [
                [
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'email',
                    ],
                ]
            ]
        ));

        $this->add_field((new acf_fields\file('File', 'file', '1509032109t'))->set_setting('conditional_logic',
            [
                [
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'download',
                    ],
                ]
            ]
        ));

        $this->add_field((new acf_fields\true_false('Open link in new window/tab', 'target_blank',
            '1509111327a'))->set_setting('conditional_logic',
            [
                [
                    [
                        'field' => '1509032104a',
                        'operator' => '!=',
                        'value' => 'email',
                    ],
                ]
            ]
        ));

    }

    /**
     * @param $css_class
     */
    public function set_css_class($css_class)
    {

        $this->css_class = $css_class;

    }

    /**
     * @return string|void
     */
    public function get_brick_html()
    {

        $html = '';

        switch ($this->get_field('type')) {

            case 'internal' :

                $html = $this->get_internal_html();
                break;

            case 'external' :

                $html = $this->get_external_html();
                break;

            case 'email' :

                $html = $this->get_email_html();
                break;

            case 'download' :

                $html = $this->get_download_html();
                break;

        }

        return '<p>' . $html . '</p>';

    }

    /**
     * @return string
     */
    private function get_internal_html()
    {

        $html = '';

        $object_id = $this->get_field('internal_item');

        if (!empty($object_id)) {

            $attributes = [];
            $attributes['href'] = get_the_permalink($object_id);
            $attributes['class'] = 'btn-default';

            $html = $this->get_button_html($attributes);

        }

        return $html;

    }

    /**
     * @return string
     */
    private function get_external_html()
    {

        $html = '';

        $href = $this->get_field('external_url');

        if (!empty($href)) {

            $attributes = [];
            $attributes['href'] = $href;
            $attributes['class'] = 'btn-default';

            $html = $this->get_button_html($attributes);

        }

        return $html;

    }

    /**
     * @return string
     */
    private function get_email_html()
    {

        $html = '';

        $href = $this->get_field('email');

        if (!empty($href)) {

            $attributes = [];
            $attributes['href'] = 'mailto:' . $href;
            $attributes['class'] = 'btn-default';

            $html = $this->get_button_html($attributes);

        }

        return $html;

    }

    /**
     * @return string
     */
    private function get_download_html()
    {

        $html = '';

        $file_id = $this->get_field('file');

        if (!empty($file_id)) {

            $attributes = [];
            $attributes['href'] = wp_get_attachment_url($file_id);
            $attributes['class'] = 'btn-default';

            $html = $this->get_button_html($attributes);

        }

        return $html;

    }

    /**
     * @param $text
     * @param $attributes
     * @return string
     */
    private function get_button_html($attributes, $text = false)
    {

        if (isset($attributes['class'])) {
            $attributes['class'] = 'btn ' . $attributes['class'];
        } else {
            $attributes['class'] = 'btn';
        }

        if(!empty($this->css_class)) {

            $attributes['class'] .= ' ' . $this->css_class;

        }

        $html = '<a';
        $html .= ' href="' . $attributes['href'] . '"';
        $html .= ' class="' . $attributes['class'] . '"';
        $html .= ($this->get_field('target_blank') ? ' target="_blank"' : '');
        $html .= '>';
        $html .= ($text == false ? $this->get_field('text') : $text);
        $html .= '</a>';

        return $html;

    }

}