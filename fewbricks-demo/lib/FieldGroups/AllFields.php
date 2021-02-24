<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use FewbricksDemo\Bricks\AcfCoreFields;
use FewbricksDemo\Bricks\ExtensionFields;

class AllFields extends FieldGroup
{

    public function set_up()
    {

        $this->add_brick(new AcfCoreFields('1812032253a', 'core_fields'));
        $this->add_brick(new ExtensionFields('1812032312a', 'extension_fields'));

        $this->set_menu_order(10)
            ->set_display_in_fewbricks_info_pane(true)
            ->set_hide_on_screen('all');

        return $this;

    }

}
