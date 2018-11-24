---
parent: Filters
layout: default
title: brick_template_base_path
nav_order: 3
permalink: filters/brick_template_base_path
---

# Filters - fewbricks/brick_template_base_path

```php
fewbricks/brick_template_base_path
```

Allows you to change the path of brick templates. If you pass a value for `$template_base_path` to
`getBrickTemplateHtml()`, this filter will be ignored. Your filter should return the path without a trailing slash.

Defaults to the directory [project_files_base_path](doc:project_files_base_path)/fewbricks-demo/lib/Bricks" in the
custom code directory.

Note that the actual file name can be filtered using [brick_template_file_name](doc:brick_template_file_name).

Your filter function can receive two parameters:
- The default value as per above
- The brick instance that the base path should be created for. By passing this, you can create a specific path for specific bricks.

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



