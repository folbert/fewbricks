<?php

namespace FewbricksDemo;

use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use FewbricksDemo\FieldGroups\AllFields;
use FewbricksDemo\FieldGroups\FooterGlobalTexts;

require_once 'setup.php';
require_once 'custom-post-types.php';

add_action('fewbricks/init', function () {

    //require_once 'inline-demo.php';

    //(new FooterGlobalTexts('Footer', '1811292313a'))->set_up();

    (new AllFields('All fields', '1812032255a'))
        ->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'fewbricks_demo_pg2')
                )
        )
        ->set_up()
        ->register();

    (new AllFields('All fields 2', '1812032255a'))
        ->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'fewbricks_demo_pg2')
                )
        )
        ->set_up()
        ->register();

});
