<?php

namespace App\Fewbricks\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;

class FieldsKitchenSink extends FieldGroup {

    /**
     *
     */
    public function build()
    {

        $this->addField(new Text('Text', 'text', '1711172249a'));
        $this->addField(new Textarea('Textarea', 'textarea', '1711172249a'));
        $this->addField(new Wysiwyg('Textarea', 'textarea', '1711172249a'));

    }

}
