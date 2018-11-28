---
parent: Filters
layout: default
title: templater/brick_templates_base_path
nav_order: 8
permalink: /filters/templater--brick-templates-base_path/
---

# Filters - fewbricks/templater/brick_templates_base_path

You only need to care about this filter if you intend to use [Fewbricks simple template engine](/bricks/templates/)
. If you don't, you can ignore this.

```php
fewbricks/templater/brick_templates_base_path
```

Allows you to change the path of brick templates. If you pass a value for `$template_base_path` to
`BrickTemplater`, this filter will be ignored. Your filter should return the path without a trailing 
slash.

Defaults to `false` which will cause `BrickTemplater` to die and tell you to specify a path. 

Note that the actual file name can be filtered using [templater/brick_template_file_name]
(/filters/templater--brick-template-file-name/).

Your filter function can receive two parameters:
- The default value as per above
- The brick instance that the base path should be created for. By passing this, you can create a specific path for 
specific bricks.

## Example
```php
<?php

add_filter('fewbricks/brick_templates_base_path', 'getBrickTemplatesBasePath', 10, 2);

function getBrickTemplatesBasePath($path, $brickInstance)
{

  // Create your own path here
  
  return $path;

}
```



