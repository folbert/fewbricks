<?php

namespace App\FewbricksDemo\FieldGroups;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
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
     *
     * @return void
     */
    public function build()
    {

        $this->addMyFields();

        if ($this->getLocationRuleGroups()->isEmpty()) {

            $this->addLocationRuleGroups([
                (new FieldGroupLocationRuleGroup())
                    ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg')),
                (new FieldGroupLocationRuleGroup())
                    ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg2')),
            ]);

        }

        $this->hideOnScreen('the_content');

    }

    /**
     * A large function adding all available fields and then some.
     */
    private function addMyFields()
    {

        $this->addField(new FAFields\Accordion('Accordion', 'accordion', '1712252132a'));

        $this->addField(new FAFields\Text('Text in accordion', 'text_in_accordion', '1712252132o'));

        $this->addField(new FAFields\Text('Another text in accordion', 'another_text_in_accordion', '1712252132y'));

        $this->addField(
            (new FAFields\Accordion('Close accordion', 'close_accordion', '1712252133a'))
            ->setEndpoint(true)
        );

        // The other fields are in alphabetical oder but lets start with a tab
        $this->addField(new FAFields\Tab('Basic fields', 'fd_tab1', '1711192019a'));

        // Showing how to set field settings after the field has been created
        $button_group = new FAFields\ButtonGroup('Button Group', 'fd_button_group', '1711172249u');
        $button_group->setChoices([
            'red'   => 'Red',
            'black' => 'Black',
        ]);
        $button_group->setSetting('required', true);
        $button_group->setDefaultValue('black');
        $this->addField($button_group);

        $this->addField(new FAFields\Checkbox('Checkbox', 'fd_checkbox',
            '1711172310a', [
                'choices'      => [
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                ],
                'allow_custom' => true,
            ]));

        $this->addField(new FAFields\ColorPicker('Color Picker', 'fd_color_picker',
            '1711172313u'));

        $this->addField(new FAFields\DatePicker('Date Picker', 'fd_date_picker',
            '1711172314y'));

        $this->addField(new FAFields\DateTimePicker('Date Time Picker',
            'fd_date_time_picker', '1711172314u'));

        $this->addField(new FAFields\Email('E-mail', 'fd_email', '17', [
            'wrapper' => ['class' => 'fewbricks_demo_wrapper'],
        ]));

        // Two fields of the same type
        $this->addField(new FAFields\File('File', 'fd_file', '1711172319o'));
        $this->addField(new FAFields\File('File 2', 'fd_file_2', '1711172319p'));

        // ----------------
        // Flexible content
        $fc = new FAFields\FlexibleContent('Flexible content', 'fd_flexible_content', '1711231849a');
        $fc->setButtonLabel('Fewbricks says: add layout');

        $l = new FAFields\Layout('Text and image', 'fd_text_and_image', '1711231901a');
        $l->addSubField(new FAFields\Text('Text', 'fd_text', '1711231901b'));
        $l->addSubField(
            (new FAFields\Image('Image', 'fd_image', '1711231901c'))
                ->setPreviewSize('large')
        );
        $fc->addLayout($l);

        // Testing duplicate keys
        /*$l = new FAFields\Layout('Text and image', 'fd_text_and_image', '1711231901i');
        $l->addSubField(new FAFields\Text('Text', 'fd_text', '1711231901b'));
        $l->addSubField(
            (new FAFields\Image('Image', 'fd_image', '1711231901b'))
                ->setPreviewSize('large')
        );
        $fc->addLayout($l);*/

        $l = new FAFields\Layout('Text and select', 'fd_text_and_select', '1711231907a');
        $l->addSubField(new FAFields\Text('Text', 'fd_text', '1711231907b'));
        $l->addSubField(new FAFields\Select('Select', 'fd_select', '1711231907c', [
            'choices' => [
                'option1' => 'Option 1',
                'option2' => 'Option 2',
            ],
        ]));
        $fc->addLayout($l);

        $this->addField($fc);
        // E.o. flexible content
        // ---------------------

        $this->addField(new FAFields\Gallery('Gallery', 'fd_gallery', '1711172320y'));

        // Commented out because this will require a valid Google Maps api key to function
        //$this->addField(new FAFields\GoogleMap('Google Map', 'google_map', '1711172321r'));

        $this->addField(new FAFields\PublicAddOns\FewbricksHidden('Fewbricks Hidden',
            'fd_fewbricks_hidden', '1711172043u'));

        // -----
        // Group
        $group = new FAFields\Group('Group', 'fd_group', '1711232310a');

        $group->addSubField(new FAFields\Text('Text', 'fd_text', '1711232310b'));
        $group->addSubField(
            (new FAFields\Select('Select', 'fd_select', '1711232310c'))
                ->setChoices([
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                ])
        );

        $this->addField($group);

        // E.o. group
        // ----------

        $this->addField(new FAFields\Image('Image', 'fd_image', '1711172323u'));

        $this->addField(new FAFields\Link('Link', 'fd_link', '1711172323g'));

        $this->addField(new FAFields\Message('Message', 'fd_message', '1711172324c', [
            'message' => 'Lorem ipsum dolor sit amet.',
        ]));

        $this->addField(new FAFields\Number('Number', 'fd_number', '1711172324u'));

        $this->addField(new FAFields\Oembed('Oembed', 'fd_oembed', '1711172325i'));

        $this->addField(new FAFields\PageLink('Page Link', 'fd_page_link', '1711172326c'));

        $this->addField(new FAFields\Password('Password', 'fd_password', '1711172326x'));

        $this->addField(new FAFields\PostObject('Post Object', 'fd_post_object', '1711172327o'));

        // --------
        // Repeater
        $repeater = new FAFields\Repeater('Repeater', 'fd_repeater', '1711222156a');

        $repeater->setButtonLabel('Fewbricks says: add row');
        $repeater->setLayout('table');

        // Passing settings as fourth parameter
        $repeater->addSubField(new FAFields\Text('Repeater - Text', 'fd_repeater_text', '1711222221a',
            ['required' => true]));

        $repeater->addSubField(new FAFields\Image('Repeater - Image', 'fd_repeater_image', '1711222221b'));

        $this->addField($repeater);
        // E.o. repeater
        // -------------

        $this->addField((new FAFields\Relationship('Relationship', 'fd_relationship', '1711242111a'))
            ->setPostType('fewbricks_demo_post')
        );

        $this->addField(new FAFields\Select('Select', 'fd_select', '1711210919a', [
            'choices'       => [
                'one'   => 'One',
                'two'   => 'Two',
                'three' => 'Three',
            ],
            'default_value' => 'two',
        ]));

        $this->addField(new FAFields\Text('Text', 'fd_text', '1711172249a'));

        $this->addField(new FAFields\Textarea('Textarea', 'fd_textarea', '1711172249b'));

        $this->addField(new FAFields\TimePicker('Time Picker', 'fd_time_picker', '1711192022a'));

        $this->addField(
            (new FAFields\Message('Testing conditional logic', 'fd_testing_conditional_logic', '1711202201x'))
                ->setMessage('This should only be shown if the checkbox _below_is checked or if the button group is set
                to "Black"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addRule(new ConditionalLogicRule('1711192022y', '==', '1'))
                )
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addRule(new ConditionalLogicRule('1711172249u', '==', 'black'))
                )
        );

        $this->addField(
            (new FAFields\TrueFalse('True/False', 'fd_true_false', '1711192022y'))
                ->setMessage('To be or not to be? Checking this field should trigger conditional logic displaying message fields above and below')
        );

        $this->addField(
            (new FAFields\Message('Testing conditional logic', 'fd_testing_conditional_statement', '1711202201a'))
                ->setMessage('This should only be shown if the checkbox _above_ is checked and the button group isset to
                 "Red"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addRule(new ConditionalLogicRule('1711192022y', '==', '1'))
                        ->addRule(new ConditionalLogicRule('1711172249u', '==', 'red'))
                )
        );

        $this->addField(new FAFields\Url('URL', 'fd_url', '1711192031i'));

        $this->addField((new FAFields\User('User', 'fd_user', '1711192032u'))
            ->setRole(['administrator', 'contributor']));

        $this->addField(new FAFields\Wysiwyg('Wysiwyg', 'fd_wysiwyg', '1711172249i',
            ['media_upload' => false, 'delay' => true]));

    }

}
