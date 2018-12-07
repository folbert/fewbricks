---
parent: Filters
layout: default
title: templater/brick_template_file_name
nav_order: 70
permalink: /filters/templater--brick-template-file-name/
---

# Filters - fewbricks/templater/brick_template_file_name

You only need to care about this filter if you intend to use [Fewbricks simple template engine](/bricks/templates/).
If you don't, you can ignore this.

Use this filter to create custom file names for bricks. By default, Fewbricks is creating the filenames, by transforming
class names like HeadlineAndText or headline_and_text to headline-and-text.view.php.

Note the addition of a file extension as well above. The ".view"-part can be changed using the filter 
[fewbricks/templater/brick_views_file_name_structure](filters/templater--brick-views-file-name-structure/)

Also please note that you can pass an argument to each instance of BrickTemplater that completely overwrites this 
filter 
for those instances.

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

add_filter('fewbricks/templater/brick_template_file_name', 'fewbricksDemoGetBrickTemplateFileName', 10, 2);

function fewbricksDemoGetBrickTemplateFileName($fileName, $brickObject) {
  
  $myFileName = strtolower(get_class($brickObject)) . '.tpl.php';
  
  return $myFileName;
  
}
```
