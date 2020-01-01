---
parent: Filters
layout: default
title: fewbricks/exporter/php/auto_write_target
nav_order: 40
permalink: /filters/exporter--php--auto_write_target/
---

# Filters - fewbricks/exporter/php/auto_write_target
Use this to enable writing the resulting ACF-code that Fewbricks generates to a PHP-file. The writing will be done on every page load so you should not have this enabled in production environments. See [Exporter](/exporter) for more info.

You could use this filter to produce the PHP code in your dev environment and then in your production environment, you disable Fewbricks and just read the ACF settings from the PHP file instead. Note that this is not feasible if you have custom PHP code when creating field groups and fields. If you for example are using PHP code to fetch some external value to use as default value for a field, this code will be lost when writing to the PHP file.

## Possible values
- `false` - this will disable writing the PHP code to a file completely. This is the default value.
- A string with a valid file path where the code should be written. This must include the filename.

## Example
```php
<?php
add_filter('fewbricks/dev_mode/enable', function($target) {
    return get_stylesheet_directory() . '/fewbricks-code.php';
});
```


