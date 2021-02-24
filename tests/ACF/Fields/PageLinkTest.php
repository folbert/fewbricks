<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\PageLink;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class PageLinkTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\PageLink';

    /**
     *
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(self::CLASS_NAME));
    }

    /**
     *
     */
    public function testAcfArray()
    {

        $settings = [
            // Used for creating the field object
            'label' => 'A field',
            'name' => 'name_of_the_field_et87giu',
            'key' => '1812101016a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812101016b',
            // These wil be set using setters on the field object
        ];

        $field = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings, $this);

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    /**
     *
     */
    public function testSetAndGetAllowArchives()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals(1, $field->get_allow_archives());

        $field->set_allow_archives(false);

        $this->assertEquals(false, $field->get_allow_archives());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals(0, $field->get_multiple());

        $field->set_multiple(true);

        $this->assertEquals(true, $field->get_multiple());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals([], $field->get_post_type());

        $field->set_post_type(['post', 'page']);

        $this->assertEquals(['post', 'page'], $field->get_post_type());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals([], $field->get_taxonomy());

        $field->set_taxonomy(['post', 'page']);

        $this->assertEquals(['post', 'page'], $field->get_taxonomy());

    }

}
