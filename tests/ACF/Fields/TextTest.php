<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Text;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;
use Fewbricks\Tests\Helper;

final class TextTest extends Field
{

    const CLASS_NAME = 'Fewbricks\ACF\Fields\Text';

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
            'test__key_prefix' => '1812092118b',
            'label' => 'A text field',
            'name' => 'name_of_the_text_field_et87giu',
            'key' => '1812092118a',
            'required' => true,
        ];

        $textField = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings);

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($textField, $settings),
            $textField->toAcfArray($settings['test__key_prefix'])
        );

    }

}
