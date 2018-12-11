<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use FewbricksDemo\Bricks\AcfCoreFields;
use FewbricksDemo\Bricks\ExtensionFields;

class AllFields extends FieldGroup
{

    public function setUp()
    {

        $this->addBrick(new AcfCoreFields('core_fields', '1812032253a'));
        $this->addBrick(new ExtensionFields('extension_fields', '1812032312a'));

        $this->setMenuOrder(10)
            ->setShowInFewbricksDevTools(true)
            ->setHideOnScreen('all');

        return $this;

    }

}
