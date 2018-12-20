<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\PageLink;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class PageLinkTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAllowArchives()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals(true, $field->getAllowArchives());

        $field->setAllowArchives(false);

        $this->assertEquals(false, $field->getAllowArchives());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals(false, $field->getMultiple());

        $field->setMultiple(true);

        $this->assertEquals(true, $field->getMultiple());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals([], $field->getPostType());

        $field->setPostType(['post', 'page']);

        $this->assertEquals(['post', 'page'], $field->getPostType());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new PageLink('', '', '');

        $this->assertEquals([], $field->getTaxonomy());

        $field->setTaxonomy(['post', 'page']);

        $this->assertEquals(['post', 'page'], $field->getTaxonomy());

    }

}
