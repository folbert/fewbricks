<?php

namespace App\FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupInterface;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields as FAFields;
use Fewbricks\ACF\Layout;
use Fewbricks\ACF\Rule;

/**
 * Class Demo_FieldsKitchenSink
 * Testing and demoing all the field types and ideas on how to do stuff.
 *
 * @package App\Fewbricks\FieldGroups
 */
class FieldsKitchenSink extends FieldGroup implements FieldGroupInterface
{

    /**
     * FieldsKitchenSink constructor.
     *
     * @param       $key
     * @param array $settings
     * @param array $args
     */
    public function __construct($key, $settings = [], $args = [])
    {

        parent::__construct('Kitchen Sink', $key, $settings, $args);
    }

    /**
     * Any class extending FieldGroup can have a function named build. This function will be called
     * right before the field group is registered to ACF. Inside this function you can do whatever you want.
     * This basically enables you to have a field group that can be reused and by utilizong the $args that you can pass
     * when instantiating an object, you can affect which fields should be included etc.
     * @return void
     */
    public function build()
    {

        $this->addMyFields();

        if($this->getLocationRuleGroups()->isEmpty()) {

            $this->addLocationRuleGroups([
                (new FieldGroupLocationRuleGroup())
                    ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg')),
                (new FieldGroupLocationRuleGroup())
                    ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg2'))
            ]);

        }

        $this->hideOnScreen('the_content');

    }

    /**
     * A large function adding all available fields and then some.
     */
    private function addMyFields()
    {

        // The other fields are in alphabetical oder but lets start with a tab
        $this->addField(new FAFields\Tab('Basic fields', 'tab1', '1711192019a'));

        // Showing how to set field settings after the field has been created
        $button_group = new FAFields\ButtonGroup('Button Group',
            'button_group', '1711172249u');
        $button_group->setChoices([
            'red'   => 'Red',
            'black' => 'Black',
        ]);
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

        // ----------------
        // Flexible content
        $fc = new FAFields\FlexibleContent('Flexible content', 'flexible_content', '1711231849a');
        $fc->setButtonLabel('Fewbricks says: add layout');

        $l = new FAFields\Layout('Text and image', 'text_and_image', '1711231901a');
        $l->addSubField(new FAFields\Text('Text', 'text', '1711231901b'));
        $l->addSubField(
            (new FAFields\Image('Image', 'image', '1711231901c'))
                ->setPreviewSize('large')
        );
        $fc->addLayout($l);

        $l = new FAFields\Layout('Text and select', 'text_and_select', '1711231907a');
        $l->addSubField(new FAFields\Text('Text', 'text', '1711231907b'));
        $l->addSubField(new FAFields\Select('Select', 'select', '1711231907c', [
            'choices' => [
                'option1' => 'Option 1',
                'option2' => 'Option 2',
            ],
        ]));
        $fc->addLayout($l);

        $this->addField($fc);
        // E.o. flexible content
        // ---------------------

        $this->addField(new FAFields\Gallery('Gallery', 'gallery',
            '1711172320y'));

        // Commented out because this will require a valid Google Maps api key to function
        //$this->addField(new FAFields\GoogleMap('Google Map', 'google_map', '1711172321r'));

        $this->addField(new FAFields\PublicAddOns\FewbricksHidden('Fewbricks Hidden',
            'fewbricks_hidden', '1711172043u'));

        // -----
        // Group
        $group = new FAFields\Group('Group', 'group', '1711232310a');

        $group->addSubField(new FAFields\Text('Text', 'text', '1711232310b'));
        $group->addSubField(
            (new FAFields\Select('Select', 'select', '1711232310c'))
                ->setChoices([
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                ])
        );

        $this->addField($group);

        // E.o. group
        // ----------

        $this->addField(new FAFields\Image('Image', 'image', '1711172323u'));

        $this->addField(new FAFields\Link('Link', 'link', '1711172323g'));

        $this->addField(new FAFields\Message('Message', 'message',
            '1711172324c', [
                'message' => 'Lorem ipsum dolor sit amet.',
            ]));

        $this->addField(new FAFields\Number('Number', 'number', '1711172324u'));

        $this->addField(new FAFields\Oembed('Oembed', 'oembed', '1711172325i'));

        $this->addField(new FAFields\PageLink('Page Link', 'page_link',
            '1711172326c'));

        $this->addField(new FAFields\Password('Password', 'password',
            '1711172326x'));

        $this->addField(new FAFields\PostObject('Post Object', 'post_object',
            '1711172327o'));

        // --------
        // Repeater
        $repeater = new FAFields\Repeater('Repeater', 'repeater',
            '1711222156a');

        $repeater->setButtonLabel('Fewbricks says: add row');
        $repeater->setLayout('table');

        // Passing settings as fourth parameter
        $repeater->addSubField(new FAFields\Text('Repeater - Text',
            'repeater_text', '1711222221a', ['required' => true]));

        $repeater->addSubField(new FAFields\Image('Repeater - Image',
            'repeater_image', '1711222221b'));

        $this->addField($repeater);
        // E.o. repeater
        // -------------

        $this->addField((new FAFields\Relationship('Relationship', 'relationship', '1711242111a'))
            ->setPostType('fewbricks_demo_post')
        );

        $this->addField(new FAFields\Select('Select', 'select', '1711210919a', [
            'choices'       => [
                'one'   => 'One',
                'two'   => 'Two',
                'three' => 'Three',
            ],
            'default_value' => 'two',
        ]));

        $this->addField(new FAFields\Text('Text', 'text', '1711172249a'));

        $this->addField(new FAFields\Textarea('Textarea', 'textarea',
            '1711172249b'));

        $this->addField(new FAFields\TimePicker('Time Picker', 'time_picker',
            '1711192022a'));

        $this->addField(new FAFields\Message('Testing conditional statement',
            'testing_conditional_logic', '1711202201x', [
                'message'           => 'This should only be shown if the checkbox _below_
                is checked',
                'conditional_logic' => [
                    [
                        [
                            'field'    => '1711192022y',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ]));

        $this->addField(new FAFields\TrueFalse('True/False', 'true_false',
            '1711192022y', [
                'message' => 'To be or not to be? Checking this field should
                trigger a conditional statement displaying a message field
                above and below',
            ]));

        $this->addField(new FAFields\Message('Testing conditional statement',
            'testing_conditional_statement', '1711202201a', [
                'message'           => 'This should only be shown if the checkbox _above_
                is checked',
                'conditional_logic' => [
                    [
                        [
                            'field'    => '1711192022y',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ]));

        $this->addField(new FAFields\Url('URL', 'url', '1711192031i'));

        $this->addField((new FAFields\User('User', 'user', '1711192032u'))
            ->setRole(['administrator', 'contributor']));

        $this->addField(new FAFields\Wysiwyg('Wysiwyg', 'wysiwyg',
            '1711172249i', ['media_upload' => false, 'delay' => true]));

    }

}
