<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class button extends project_brick {

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Button';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field((new acf_fields\select('Type', 'type', '1509032104a'))
            ->set_setting('choices',
            [
                'internal' => 'Internal',
                'external' => 'External',
                'email' => 'E-mail',
                'file' => 'File',
            ])
            ->set_setting('allow_null', 'false')
        );

        $this->add_field(
            (new acf_fields\post_object('Item', 'internal_item', '1509032109u'))->set_setting('conditional_logic',
                [[
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'internal',
                    ],
                ]]
            ));

        $this->add_field(
            (new acf_fields\url('URL', 'external_url', '1509032109r'))->set_setting('conditional_logic',
                [[
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'external',
                    ],
                ]]
            ));

        $this->add_field((new acf_fields\email('E-mail', 'e_mail', '1509032109s'))->set_setting('conditional_logic',
                [[
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'email',
                    ],
                ]]
            ));

        $this->add_field((new acf_fields\file('File', 'file', '1509032109t'))->set_setting('conditional_logic',
                [[
                    [
                        'field' => '1509032104a',
                        'operator' => '==',
                        'value' => 'file',
                    ],
                ]]
            ));

    }

    /**
     * @param array $args
     */
    public function get_html($args = [])
    {

    }

}