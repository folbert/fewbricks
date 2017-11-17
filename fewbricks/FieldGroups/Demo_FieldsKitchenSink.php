<?php

namespace App\Fewbricks\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields as FAFields;

/**
 * Class Demo_FieldsKitchenSink
 * Testing and demoing all the field types and ideas on how to do stuff.
 *
 * @package App\Fewbricks\FieldGroups
 */
class Demo_FieldsKitchenSink extends FieldGroup
{

    /**
     *
     */
    public function build()
    {

        // Showing how to set field settings after the field has been created
        $button_group         = new FAFields\ButtonGroup('Button Group',
            'button_group', '1711172249u');
        $button_group_choices = [
            'red'   => 'Red',
            'black' => 'Black',
        ];
        $button_group->setSetting('choices', $button_group_choices);
        $button_group->setSetting('required', true);
        $this->addField($button_group);

        $this->addField(new FAFields\Checkbox('Checkbox', 'checkbox',
            '1711172310a', [
                'choices'      => [
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                ],
                'allow_custom' => true,
            ]));

        $this->addField(new FAFields\ColorPicker('Color Picker', 'color_picker',
            '1711172313u'));

        $this->addField(new FAFields\DatePicker('Date Picker', 'date_picker',
            '1711172314y'));

        $this->addField(new FAFields\DateTimePicker('Date Time Picker',
            'date_time_picker', '1711172314u'));

        $this->addField(new FAFields\Email('E-mail', 'email', '1711172314y', [
            'wrapper' => ['class' => 'fewbricks_demo_wrapper'],
        ]));

        // Two fields of the same type
        $this->addField(new FAFields\File('File', 'file', '1711172319o'));
        $this->addField(new FAFields\File('File 2', 'file_2', '1711172319p'));

        $this->addField(new FAFields\Gallery('Gallery', 'gallery',
            '1711172320y'));

        // Commented out because this will require a valid Google Maps api key to function
        //$this->addField(new FAFields\GoogleMap('Google Map', 'google_map', '1711172321r'));

        $this->addField(new FAFields\Image('Image', 'image', '1711172323u'));

        $this->addField(new FAFields\Link('Link', 'link', '1711172323g'));

        $this->addField(new FAFields\Message('Message', 'message',
            '1711172324c', [
                'message' => 'Lorem ipsum dolor sit amet.',
            ]));

        $this->addField(new FAFields\Number('Number', 'number', '1711172324u'));

        $this->addField(new FAFields\Oembed('Oembed', 'oembed', '1711172325i'));

        $this->addField(new FAFields\PageLink('Page Link', 'page_link', '1711172326c'));

        $this->addField(new FAFields\Password('Password', 'password', '1711172326x'));

        $this->addField(new FAFields\PostObject('Post Object', 'post_object', '1711172327o'));

        $this->addField(new FAFields\Text('Text', 'text', '1711172249a'));

        $this->addField(new FAFields\Textarea('Textarea', 'textarea',
            '1711172249b'));

        // Here we pass settings directrly as the fourth parameter
        $this->addField(new FAFields\Wysiwyg('Wysiwyg', 'wysiwyg',
            '1711172249i', ['media_upload' => false, 'delay' => true]));

    }

}
