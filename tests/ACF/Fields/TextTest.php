<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Text;
use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Fewbricks\ACF\Fields\Text'));
    }

    public function testAcfArray()
    {

        $textField = new Text('A text field', 'name_of_the_text_field_et87giu', '1812092118a');
        $textField->setRequired(true);

        $this->assertEquals(
            [
                'key' => 'field_1812092118b_1812092118a',
                'label' => 'A text field',
                'name' => 'name_of_the_text_field_et87giu',
                'fewbricks__original_key' => '1812092118a',
                'fewbricks__parents' => [],
                'type' => 'text',
                'required' => true,
            ],
            $textField->toAcfArray('1812092118b')
        );

    }


}
