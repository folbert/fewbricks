<?php

namespace FewbricksDemo;

use FewbricksDemo\FieldGroups\FooterGlobalTexts;

require_once 'setup.php';

add_action('fewbricks/init', function () {

    require_once 'inline-demo.php';

    (new FooterGlobalTexts('Footer', '1811292313a'))->setup();

});
