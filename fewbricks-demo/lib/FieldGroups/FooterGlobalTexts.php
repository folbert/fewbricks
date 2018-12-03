<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use FewbricksDemo\Bricks\Headline;

class FooterGlobalTexts extends FieldGroup
{

    public function setup()
    {

        $this->addBrick(
            (new Headline('column_1_headline', '1811292314a'))
            ->addArgument('label', 'Column 1 Headline')
        );

        $this->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('options_page', '==', 'fewbricks-demo-options--global-texts')
            )
        );

        $this->setMenuOrder(20)
            ->setShowInFewbricksDevTools(true)
            ->setStyle('seamless')
            ->register();

    }

}
