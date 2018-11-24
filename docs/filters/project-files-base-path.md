---
parent: Filters
layout: default
title: project_files_base_path
nav_order: 6
permalink: filters/project_files_base_path
---

# Filters - fewbricks/project_files_base_path

Allows you to change the location of your custom Fewbricks code. Do not include a trailing slash.

```php
fewbricks/project_files_base_path
```

## Example

```php
<?php

add_filter('fewbricks/project_files_base_path', function() {
  return get_template_directory() . '/project-fewbricks';
});
```





