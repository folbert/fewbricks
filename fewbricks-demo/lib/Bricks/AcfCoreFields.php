<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Accordion;
use Fewbricks\ACF\Fields\ButtonGroup;
use Fewbricks\ACF\Fields\Checkbox;
use Fewbricks\ACF\Fields\ColorPicker;
use Fewbricks\ACF\Fields\DatePicker;
use Fewbricks\ACF\Fields\DateTimePicker;
use Fewbricks\ACF\Fields\Email;
use Fewbricks\ACF\Fields\Extensions\FewbricksHidden;
use Fewbricks\ACF\Fields\File;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Gallery;
use Fewbricks\ACF\Fields\GoogleMap;
use Fewbricks\ACF\Fields\Group;
use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Link;
use Fewbricks\ACF\Fields\Message;
use Fewbricks\ACF\Fields\Number;
use Fewbricks\ACF\Fields\Oembed;
use Fewbricks\ACF\Fields\PageLink;
use Fewbricks\ACF\Fields\Password;
use Fewbricks\ACF\Fields\PostObject;
use Fewbricks\ACF\Fields\Relationship;
use Fewbricks\ACF\Fields\Repeater;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Tab;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\ACF\Fields\TimePicker;
use Fewbricks\ACF\Fields\TrueFalse;
use Fewbricks\ACF\Fields\Url;
use Fewbricks\ACF\Fields\User;
use Fewbricks\ACF\Fields\Wysiwyg;

class AcfCoreFields extends Brick
{

    /**
     *
     */
    public function setup()
    {

        $this->addField(new Text('Text', 'fd_text', '18120621210a'));

        // Showing how to set field settings after the field has been created
        $button_group = new ButtonGroup('Button Group', 'fd_button_group', '1711172249u');
        $button_group->setChoices([
            'red' => 'Red',
            'black' => 'Black',
            'green' => 'Green',
        ])
            ->setSetting('required', true)
            ->setDefaultValue('black');

        $this->addField($button_group);

        $this->addField(
            (new Message('Testing conditional logic', 'fd_testing_conditional_logic', '1711202201x'))
                ->setMessage('This should only be shown if the checkbox _below_is checked or if the button group is set
                to "Black"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                )
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711172249u', '==', 'black')
                        )
                )
        );

        $this->addField(
            (new TrueFalse('True/False', 'fd_true_false', '1711192022y'))
                ->setMessage('Checking this field should trigger conditional logic displaying message fields above and below')
        );

        $this->addField(
            (new Message('Testing conditional logic', 'fd_testing_conditional_statement', '1711202201a'))
                ->setMessage('This should only be shown if the checkbox _above_ is checked and the button group isset to
                 "Red"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711172249u', '==', 'red')
                        )
                )
        );

        // ----------------
        // Flexible content
        $flexible_content = new FlexibleContent('Flexible content', 'fd_flexible_content', '1711231849a');
        $flexible_content->setButtonLabel('Fewbricks says: add layout');

        $layout = new Layout('Text and image', 'fd_text_and_image', '1711231901a');
        $layout->addField(new Text('Text', 'fd_text', '1711231901b'));
        $layout->addField(
            (new Image('Image', 'fd_image', '1711231901c'))
                ->setPreviewSize('thumbnail')
        );
        $flexible_content->addLayout($layout);

        // Testing duplicate keys
        /*$layout = new Layout('Text and image', 'fd_text_and_image', '1711231901i');
        $layout->addField(new Text('Text', 'fd_text', '1711231901b'));
        $layout->addField(
            (new Image('Image', 'fd_image', '1711231901b'))
                ->setPreviewSize('large')
        );
        $flexible_content->addLayout($layout);*/

        $layout = new Layout('Testing brick', 'fd_testing_brick', '1812051452a');
        $layout->addBrick(new ImageAndText('brick_test', '1812051452u'));
        $flexible_content->addLayout($layout);

        $layout = new Layout('Text and select', 'fd_text_and_select', '1711231907a');
        $layout->addField(new Text('Text', 'fd_text', '1711231907b'));
        $layout->addField(new Select('Select', 'fd_select', '1711231907c', [
            'choices' => [
                'option1' => 'Option 1',
                'option2' => 'Option 2',
            ],
        ]));
        $flexible_content->addLayout($layout);

        $layout = new Layout('Single image', 'fd_single_image', '1712252217a');
        $layout->addField(new Image('Image', 'fd_image', '1712252218i'));
        $flexible_content->addLayout($layout);

        // This is of course a somewhat stupid usage of the functionality since we could simply
        // not add the sub field to start with. But for demo purposes...
        $layoutsToRemove = $this->getArgument('remove_layouts', false);
        if ($layoutsToRemove !== false) {
            foreach ($layoutsToRemove AS $layoutToRemove) {
                $flexible_content->removeLayout($layoutToRemove);
            }

            $flexible_content->setInstructions('This flexible content have had some layouts removed.');

        }

        $this->addField($flexible_content);
        // E.o. flexible content
        // ---------------------

        // --------
        // Repeater
        $repeater = new Repeater('Repeater', 'fd_repeater', '1711222156a');

        $repeater->setButtonLabel('Fewbricks says: add row')
            ->setLayout('block')
            ->setCollapsed('1712252216a');

        // Passing settings as fourth parameter
        $repeater->addField(
            (new Text('Repeater - Text', 'fd_repeater_text', '1711222221a'))
                ->setRequired(true)
        );

        $repeater->addField(new Image('Repeater - Image', 'fd_repeater_image', '1711222221b'));
        $repeater->addField(new Text('Repeater - Text 2', 'fd_repeater_text_2', '1712252216a'));
        $repeater->addField(new Text('Repeater - Text 3', 'fd_repeater_text_3', '1812062132a'));

        $this->addField($repeater);
        // E.o. repeater
        // -------------


    }

    function t() {

        $this->addField(
            (new Accordion('Accordion', 'accordion', '1712252132a'))
                ->setOpen(true)
        );

        $this->addField(new Text('Text in accordion', 'text_in_accordion', '1712252132o'));

        $this->addField(new Text('Another text in accordion', 'another_text_in_accordion', '1712252132y'));

        $this->addField(
            (new Accordion('Close accordion', 'close_accordion', '1712252133a'))
                ->setEndpoint(true)
        );

        // The other fields are in alphabetical oder but lets start with a tab
        $this->addField(new Tab('Basic fields', 'fd_tab1', '1711192019a'));

        $this->addField(new Checkbox('Checkbox', 'fd_checkbox',
            '1711172310a', [
                'choices' => [
                    'one' => 'One',
                    'two' => 'Two',
                    'three' => 'Three',
                ],
                'allow_custom' => true,
            ]));

        $this->addField(new ColorPicker('Color Picker', 'fd_color_picker',
            '1711172313u'));

        $this->addField(new DatePicker('Date Picker', 'fd_date_picker',
            '1711172314y'));

        $this->addField(new DateTimePicker('Date Time Picker',
            'fd_date_time_picker', '1711172314u'));

        $this->addField(new Email('E-mail', 'fd_email', '1801022310a', [
            'wrapper' => ['class' => 'fewbricks_demo_wrapper'],
        ]));

        // Two fields of the same type
        $this->addField(new File('File', 'fd_file', '1711172319o'));
        $this->addField(new File('File 2', 'fd_file_2', '1711172319p'));

        // ----------------
        // Flexible content
        $flexible_content = new FlexibleContent('Flexible content', 'fd_flexible_content', '1711231849a');
        $flexible_content->setButtonLabel('Fewbricks says: add layout');

        $layout = new Layout('Text and image', 'fd_text_and_image', '1711231901a');
        $layout->addField(new Text('Text', 'fd_text', '1711231901b'));
        $layout->addField(
            (new Image('Image', 'fd_image', '1711231901c'))
                ->setPreviewSize('thumbnail')
        );
        $flexible_content->addLayout($layout);

        // Testing duplicate keys
        /*$l = new Layout('Text and image', 'fd_text_and_image', '1711231901i');
        $l->addSubField(new Text('Text', 'fd_text', '1711231901b'));
        $l->addSubField(
            (new Image('Image', 'fd_image', '1711231901b'))
                ->setPreviewSize('large')
        );
        $fc->addLayout($l);*/

        $layout = new Layout('Text and select', 'fd_text_and_select', '1711231907a');
        $layout->addField(new Text('Text', 'fd_text', '1711231907b'));
        $layout->addField(new Select('Select', 'fd_select', '1711231907c', [
            'choices' => [
                'option1' => 'Option 1',
                'option2' => 'Option 2',
            ],
        ]));
        $flexible_content->addLayout($layout);

        $layout = new Layout('Single image', 'fd_single_image', '1712252217a');
        $layout->addField(new Image('Image', 'fd_image', '1712252218i'));
        $flexible_content->addLayout($layout);

        // This is of course a somewhat stupid usage of the functionality since we could simply
        // not add the sub field to start with. But for demo purposes...
        $layoutsToRemove = $this->getArgument('remove_layouts', false);
        if ($layoutsToRemove !== false) {
            foreach ($layoutsToRemove AS $layoutToRemove) {
                $flexible_content->removeLayout($layoutToRemove);
            }

            $flexible_content->setInstructions('This flexible content have had some layouts removed.');

        }

        $this->addField($flexible_content);
        // E.o. flexible content
        // ---------------------

        $this->addField(new Gallery('Gallery', 'fd_gallery', '1711172320y'));

        // Commented out because this will require a valid Google Maps api key to function
        //$this->addField(new GoogleMap('Google Map', 'google_map', '1711172321r'));

        // You wont be able to see this
        $this->addField(new FewbricksHidden('Fewbricks Hidden',
            'fd_fewbricks_hidden', '1711172043u'));

        // -----
        // Group
        $group = new Group('Group', 'fd_group', '1711232310a');

        $group->addField(new Text('Text', 'fd_text', '1711232310b'));
        $group->addField((new Select('Select', 'fd_select', '1711232310c'))
            ->setChoices([
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
            ])
        );

        $this->addField($group);

        // E.o. group
        // ----------

        $this->addField(new Image('Image', 'fd_image', '1711172323u'));

        $this->addField(new Link('Link', 'fd_link', '1711172323g'));

        $this->addField(new Message('Message', 'fd_message', '1711172324c', [
            'message' => 'Lorem ipsum dolor sit amet.',
        ]));

        $this->addField(new Number('Number', 'fd_number', '1711172324u'));

        $this->addField(new Oembed('Oembed', 'fd_oembed', '1711172325i'));

        $this->addField(new PageLink('Page Link', 'fd_page_link', '1711172326c'));

        $this->addField(new Password('Password', 'fd_password', '1711172326x'));

        $this->addField(new PostObject('Post Object', 'fd_post_object', '1711172327o'));

        $this->addField((new Relationship('Relationship', 'fd_relationship', '1711242111a'))
            ->setPostType(['fewbricks_demo_post'])
        );

        $this->addField((new Select('Select', 'fd_select', '1711210919a'))
            ->setChoices([
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
            ])
            ->setDefaultValue('two'));

        $this->addField(new Text('Text', 'fd_text', '1711172249a'));

        $this->addField(new Textarea('Textarea', 'fd_textarea', '1711172249b'));

        $this->addField(new TimePicker('Time Picker', 'fd_time_picker', '1711192022a'));

        $this->addField(
            (new Message('Testing conditional logic', 'fd_testing_conditional_logic', '1711202201x'))
                ->setMessage('This should only be shown if the checkbox _below_is checked or if the button group is set
                to "Black"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                )
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711172249u', '==', 'black')
                        )
                )
        );

        $this->addField(
            (new TrueFalse('True/False', 'fd_true_false', '1711192022y'))
                ->setMessage('Checking this field should trigger conditional logic displaying message fields above and below')
        );

        $this->addField(
            (new Message('Testing conditional logic', 'fd_testing_conditional_statement', '1711202201a'))
                ->setMessage('This should only be shown if the checkbox _above_ is checked and the button group isset to
                 "Red"')
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                        ->addConditionalLogicRule(
                            new ConditionalLogicRule('1711172249u', '==', 'red')
                        )
                )
        );

        $this->addField(new Url('URL', 'fd_url', '1711192031i'));

        $this->addField((new User('User', 'fd_user', '1711192032u'))
            ->setRole(['administrator', 'contributor']));

        $this->addField(new Wysiwyg('Wysiwyg', 'fd_wysiwyg', '1711172249i',
            ['media_upload' => false, 'delay' => true]));

        // Showing off another tab
        $this->addField(new Tab('Another tab', 'fd_tab2', '1811212230a'));

        $this->addField((new Text('Another text field under Another tab', 'fd_text2', '1811212231a')));


    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['text', 'image']);

    }

}
