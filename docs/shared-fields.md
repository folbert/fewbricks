---
layout: default
title: Shared fields
nav_order: 7
permalink: /shared-fields
---

# Shared fields

Sometimes you may want to create a colleciton of fields (or just ine field) that can be used multiple times but you don't need all the extra stuff that you get with a Brick. This is where Shared Fields comes in.

Here's a class that holds a selectbox with all the available background colors for a site. The class is extending `SharedFields` which in turn extends `FieldCollection` ([Field Collections](doc:field-collections)). So basically what you have here is a collection of fields.

```php
<?php

namespace App\FewbricksDemo\SharedFields;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\SharedFieldCollection;
use Fewbricks\SharedFields;

/**
 * Class BackgroundColors
 *
 * @package App\FewbricksDemo\SharedFields
 */
class BackgroundColors extends SharedFields
{

    /**
     * @throws \Fewbricks\KeyInUseException
     */
    protected function applyFields()
    {

        $this->addField(
            (new Select('Background color', 'background_color', '1712262153a'))
                ->setChoices([
                    'blue'  => 'Blue',
                    'green' => 'Green',
                    'red'   => 'Red',
                ])
                ->setDefaultValue('green')
        );

    }


}
```

Here's another SharedFields class which is using the background class above

```php
<?php

namespace App\FewbricksDemo\SharedFields;

use Fewbricks\ACF\Fields\Image;
use Fewbricks\SharedFieldCollection;
use Fewbricks\SharedFields;

/**
 * Class Background
 *
 * @package App\FewbricksDemo\SharedFields
 */
class Background extends SharedFields
{

    /**
     * @throws \Fewbricks\KeyInUseException
     */
    protected function applyFields()
    {

        $this->addField(new Image('Background Image', 'background_image', '1712262215a'));

        $this->addFieldCollection(new BackgroundColors());

    }

}
```

To use an instance of a shared fields, you can do something like this.

```php
<?php

$brick = new Section('section', 'Section', '1801022216a');
$brick->addFieldCollection(new Background());
```

And since we are dealing with a FieldCollection, you can do anything with the SharedFields instance that you can do
with a FieldCollection instance. So you can for example pass arguments when creating an instance and then use those
args to modify what the class actually will render.
