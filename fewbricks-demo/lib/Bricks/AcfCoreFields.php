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
    public function set_up()
    {

        $this->add_field((new Message('', 'brick_message', '1812102244b'))
            ->set_message('Image and text below is from Brick "ImageAndText'));

        $this->add_brick(new ImageAndText('1812072139a', 'imgtxt'));
        $this->add_brick(new ImageAndText('1812072139b', 'imgtxt2'));

        // ----------------
        // Flexible content
        $flexibleContent = new FlexibleContent('Flexible content', 'fd_flexible_content', '1711231849a');
        $flexibleContent->set_button_label('Fewbricks says: add layout');

        $layout = new Layout('Text and image', 'fd_text_and_image', '1711231901a');
        $layout->add_field(new Text('Text', 'fd_text', '1711231901b'));
        $layout->add_field(
            (new Image('Image', 'fd_image', '1711231901c'))
                ->set_preview_size('thumbnail')
        );
        $flexibleContent->addLayout($layout);

        // Testing duplicate keys
        $layout = new Layout('Text and image2', 'fd_text_and_image2', '1711231901o');
        $layout->add_field(new Text('Text', 'fd_text2', '1711231901b'));
        $layout->add_field(
            (new Image('Image', 'fd_image2', '1711231901c'))
                ->set_preview_size('large')
        );
        $flexibleContent->addLayout($layout);

        $layout = new Layout('Testing brick', 'fd_testing_brick', '1812051452a');
        $layout->add_brick(new ImageAndText('1812051452u', 'brick_test'));
        $flexibleContent->addLayout($layout);

        $layout = new Layout('Text and select', 'fd_text_and_select', '1711231907a');
        $layout->add_field(new Text('Text', 'fd_text', '1711231907b'))
            ->add_field(
                (new Select('Select', 'fd_select', '1711231907c'))
                    ->set_choices([
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                    ])
            );

        $flexibleContent->addLayout($layout);

        $layout = new Layout('Single image', 'fd_single_image', '1712252217a');
        $layout->add_field(new Image('Image', 'fd_image', '1712252218i'));
        $flexibleContent->addLayout($layout);

        // This is of course a somewhat stupid usage of the functionality since we could simply
        // not add the sub field to start with. But for demo purposes...
        $layoutsToRemove = $this->get_argument('remove_layouts', false);
        if ($layoutsToRemove !== false) {
            foreach ($layoutsToRemove AS $layoutToRemove) {
                $flexibleContent->removeLayout($layoutToRemove);
            }

            $flexibleContent->set_instructions('This flexible content have had some layouts removed.');

        }

        $this->add_field($flexibleContent);
        // E.o. flexible content
        // ---------------------

        // --------
        // Repeater
        $repeater = new Repeater('Repeater', 'fd_repeater', '1711222156a');

        $repeater->set_button_label('Fewbricks says: add row')
            ->set_layout('block')
            ->set_collapsed('1712252216a');

        // Passing settings as fourth parameter
        $repeater->add_field(
            (new Text('Repeater - Text', 'fd_repeater_text', '1711222221a'))
                ->set_required(true)
        );

        $repeater->add_field(new Image('Repeater - Image', 'fd_repeater_image', '1711222221b'));
        $repeater->add_field(new Text('Repeater - Text 2', 'fd_repeater_text_2', '1712252216a'));
        $repeater->add_field(new Text('Repeater - Text 3', 'fd_repeater_text_3', '1812062132a'));

        $this->add_field($repeater);
        // E.o. repeater
        // -------------

        // -----
        // Group
        $group = new Group('Group', 'fd_group', '1711232310a');

        $group->add_field(new Text('Text', 'fd_text', '1711232310b'));
        $group->add_field((new Select('Select', 'fd_select', '1711232310c'))
            ->set_choices([
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
            ])
        );

        $group->add_field((new Message('', 'group_brick_message', '1812102244a'))
        ->set_message('Image and text below is from Brick "ImageAndText'));

        $group->add_brick(new ImageAndText('1812072321a', 'imgtxt'));

        $this->add_field($group);

        // E.o. group
        // ----------

        $this->add_field((new Text('Text', 'fd_text', '18120621210a'))
        ->set_append('appended'));
        $this->add_field((new Text('Text', 'fd_text2', '18120621210o'))
            ->add_conditional_logic_rule_group(
                (new ConditionalLogicRuleGroup())
                    ->add_conditional_logic_rule(
                        new ConditionalLogicRule('18120621210a', '!=empty')
                    )
            ));

        // Showing how to set field settings after the field has been created
        $buttonGroup = new ButtonGroup('Button Group', 'fd_button_group', '1711172249u');
        $buttonGroup->set_choices([
            'red' => 'Red',
            'black' => 'Black',
            'green' => 'Green',
        ])
            ->set_setting('required', true)
            ->set_default_value('black');

        $this->add_field($buttonGroup);

        $this->add_field(
            (new Message('Testing conditional logic', 'fd_testing_conditional_logic', '1711202201x'))
                ->set_message('This should only be shown if the checkbox _below_is checked or if the button group is set
                to "Black"')
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())
                        ->add_conditional_logic_rule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                )
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())
                        ->add_conditional_logic_rule(
                            new ConditionalLogicRule('1711172249u', '==', 'black')
                        )
                )
        );

        $this->add_field(
            (new TrueFalse('True/False', 'fd_true_false', '1711192022y'))
                ->set_message('Checking this field should trigger conditional logic displaying message fields above and below')
        );

        $this->add_field(
            (new Message('Testing conditional logic', 'fd_testing_conditional_statement', '1711202201a'))
                ->set_message('This should only be shown if the checkbox _above_ is checked and the button group isset to
                 "Red"')
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())
                        ->add_conditional_logic_rule(
                            new ConditionalLogicRule('1711192022y', '==', '1')
                        )
                        ->add_conditional_logic_rule(
                            new ConditionalLogicRule('1711172249u', '==', 'red')
                        )
                )
        );

        $this->add_field(
            (new Message('Testing conditional logic', 'fd_testing_conditional_statement', '1812072101a'))
                ->set_message('This should only be set if a text field in the flexible content below is set to "banana"')
                ->add_conditional_logic_rule_group(
                    (new ConditionalLogicRuleGroup())
                        ->add_conditional_logic_rule(
                            new ConditionalLogicRule('1711231901b', '==', 'banana')
                        )
                )
                ->set_display_in_fewbricks_dev_tools(true)
        );

        $this->add_field(
            (new Accordion('Accordion', 'accordion', '1712252132a'))
                ->setOpen(true)
        );

        $this->add_field(new Text('Text in accordion', 'text_in_accordion', '1712252132o'));

        $this->add_field(new Text('Another text in accordion', 'another_text_in_accordion', '1712252132y'));

        $this->add_field(
            (new Accordion('Close accordion', 'close_accordion', '1712252133a'))
                ->set_endpoint(true)
        );

        // The other fields are in alphabetical oder but lets start with a tab
        $this->add_field(new Tab('Basic fields', 'fd_tab1', '1711192019a'));

        $this->add_field(
            (new Checkbox('Checkbox', 'fd_checkbox', '1711172310a'))
                ->set_choices([
                    'one' => 'One',
                    'two' => 'Two',
                    'three' => 'Three',
                ])
                ->setAllowCustom(true)
        );

        $this->add_field(new ColorPicker('Color Picker', 'fd_color_picker',
            '1711172313u'));

        $this->add_field(new DatePicker('Date Picker', 'fd_date_picker',
            '1711172314y'));

        $this->add_field(new DateTimePicker('Date Time Picker',
            'fd_date_time_picker', '1711172314u'));

        $this->add_field(
            (new Email('E-mail', 'fd_email', '1801022310a'))
                ->set_wrapper(['class' => 'fewbricks_demo_wrapper'])
        );

        // Two fields of the same type
        $this->add_field(new File('File', 'fd_file', '1711172319o'));
        $this->add_field(new File('File 2', 'fd_file_2', '1711172319p'));

        $this->add_field(new Gallery('Gallery', 'fd_gallery', '1711172320y'));

        // Commented out because this will require a valid Google Maps api key to function
        //$this->add_field(new GoogleMap('Google Map', 'google_map', '1711172321r'));

        // You wont be able to see this
        $this->add_field(new FewbricksHidden('Fewbricks Hidden',
            'fd_fewbricks_hidden', '1711172043u'));

        $this->add_field(new Image('Image', 'fd_image', '1711172323u'));

        $this->add_field(new Link('Link', 'fd_link', '1711172323g'));

        $this->add_field(
            (new Message('Message', 'fd_message', '1711172324c'))
                ->set_message('The man in black fled across the desert')
        );

        $this->add_field(new Number('Number', 'fd_number', '1711172324u'));

        $this->add_field(new Oembed('Oembed', 'fd_oembed', '1711172325i'));

        $this->add_field(new PageLink('Page Link', 'fd_page_link', '1711172326c'));

        $this->add_field(new Password('Password', 'fd_password', '1711172326x'));

        $this->add_field(new PostObject('Post Object', 'fd_post_object', '1711172327o'));

        $this->add_field((new Relationship('Relationship', 'fd_relationship', '1711242111a'))
            ->set_post_type(['fewbricks_demo_post'])
        );

        $this->add_field((new Select('Select', 'fd_select', '1711210919a'))
            ->set_choices([
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
            ])
            ->set_default_value('two'));

        $this->add_field(new Text('Text', 'fd_text', '1711172249a'));

        $this->add_field(new Textarea('Textarea', 'fd_textarea', '1711172249b'));

        $this->add_field(new TimePicker('Time Picker', 'fd_time_picker', '1711192022a'));

        $this->add_field(new Url('URL', 'fd_url', '1711192031i'));

        $this->add_field((new User('User', 'fd_user', '1711192032u'))
            ->set_role(['administrator', 'contributor']));

        $this->add_field(
            (new Wysiwyg('Wysiwyg', 'fd_wysiwyg', '1711172249i'))
                ->set_media_upload(false)
                ->set_delay(true)
        );

        // Showing off another tab
        $this->add_field(new Tab('Another tab', 'fd_tab2', '1811212230a'));

        $this->add_field((new Text('Another text field under Another tab', 'fd_text2', '1811212231a')));


    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['text', 'image']);

    }

}
