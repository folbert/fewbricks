---
parent: Filters
layout: default
title: brick_template_file_name
nav_order: 4
permalink: filters/brick_template_file_name
---

# Filters - fewbricks/brick_template_file_name

You only need to care about this filter if you intend to use Fewbricks simple templating engine by calling `Brick::getBrickTemplateHtml()`. If you don't, you can ignore this.

Use this filter to create custom file names for bricks. When Fewbricks is creating the filenames, it transforms class
names like HeadlineAndText or headline_and_text to headline-and-text.view.php.

Note the addition of a file extension as well above.

Also note that the path to the file is set using the [brick_templates_base_path](brick_templates_base_path) filter and
should not be set using this filter. That is unless you have that filter return an empty string, then you can build
the entire path using this filter.

If this is not the way you want brick template file names to look lke, you can change it by using this filter.

Your filter function can receive two parameters:
- The file name as Fewbricks has created it as per above
- The brick instance that the file name should be created for

## Example
```php
<?php

add_filter('fewbricks/brick_template_file_name', 'fewbricksDemoGetBrickTemplateFileName', 10, 2);

function fewbricksDemoGetBrickTemplateFileName($fileName, $brickObject) {
  
  $myFileName = strtolower(get_class($brickObject)) . '.tpl.php';
  
  return $myFileName;
  
}
```
