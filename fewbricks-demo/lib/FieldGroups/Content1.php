<?php

namespace App\FewbricksDemo\FieldGroups;

use App\FewbricksDemo\Bricks\HeadlineAndText;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Layout;

/**
 * Class Content1
 *
 * @package App\FewbricksDemo\FieldGroups
 */
class Content1 extends FieldGroup
{

    public function __construct($key, array $settings = [], array $arguments = [])
    {
        parent::__construct('Content1', $key, $settings, $arguments);

        $this->addMyFields();

    }

    /**
     *
     */
    private function addMyFields()
    {

        $flexibleContent = (new FlexibleContent('Items', 'items', '1802152049a'))
        ->setButtonLabel('Add item');

        $layout = new Layout('Test', 'test', '1808241105a');
        //$flexibleContent->addLayout(new HeadlineAndText('headline_and_text', '1802152052a'));

        $this->addField($flexibleContent);

    }


}
