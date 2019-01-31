<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use FewbricksDemo\Bricks\Headline;

class FooterGlobalTexts extends FieldGroup
{

    public function set_up()
    {

        $this->add_brick(
            (new Headline('column_1_headline', '1811292314a'))
            ->add_argument('label', 'Column 1 Headline')
        );

        $this->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('options_page', '==', 'fewbricks-demo-options--global-texts')
            )
        );

        $this->set_menu_order(20)
            ->set_display_in_fewbricks_dev_tools(true)
            ->set_style('seamless')
            ->register();

    }

}
