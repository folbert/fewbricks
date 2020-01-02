---
layout: default
title: Filters
nav_order: 110
has_children: true
permalink: /filters/
---

# Filters
{: .no_toc }

## Table of contents
{: .no_toc .text-delta }

- TOC
{:toc}




## fewbricks/dev_mode/enable
Enable/disable [Dev Mode](/dev-mode).

### Possible values
{: .no_toc }
- `false` - disables Dev Mode. This is the default value.
- `true` - enables Dev Mode.

### Example
{: .no_toc }
```php
<?php
add_filter('fewbricks/dev_mode/enable', '__return_true');
```





## fewbricks/exporter/php/display_file_written_message
Have this filter return `false` to hide message in the admin area when the PHP code file has been written. If not
applied or set to return true, each page load in the admin area will generate a message telling you that the code has
been written to the file you have specified in  [auto_write_php_code_file](doc:auto_write_php_code_file).





## fewbricks/exporter/php/auto_write_target
Use this to enable writing the resulting ACF-code that Fewbricks generates to a PHP-file. The writing will be done on every page load so you should not have this enabled in production environments. See [Exporter](/exporter) for more info.

You could use this filter to produce the PHP code in your dev environment and then in your production environment, you disable Fewbricks and just read the ACF settings from the PHP file instead. Note that this is not feasible if you have custom PHP code when creating field groups and fields. If you for example are using PHP code to fetch some external value to use as default value for a field, this code will be lost when writing to the PHP file.

## Possible values
{: .no_toc }
- `false` - this will disable writing the PHP code to a file completely. This is the default value.
- A string with a valid file path where the code should be written. This must include the filename.

## Example
{: .no_toc }
```php
<?php
add_filter('fewbricks/dev_mode/enable', function($target) {
    return get_stylesheet_directory() . '/fewbricks-code.php';
});
```





## fewbricks/info_pane/display
Set whether you want to display the [Fewbricks Info Pane](/info-pane) or not. Defaults to `false`.

## Possible values
{: .no_toc }
- `false` to not display the info pane at all. This is the default value so you don't have to add the filter at all if this
is what you want.
- `true` - display the info pane with a start height of "minimized".
- a numeric value between `0` and `100` to use for the css property "vh" on the info pane main element.

## Example
{: .no_toc }
```php
<?php
add_filter('fewbricks/info_pane/display', '__return_true');
```





## fewbricks/info_pane/acf_arrays/display_all
Set whether or not the [Fewbricks Info Pane](/info-pane) (which must be enabled for this filter to have any effect) should display all ACF arrays or not. If you set this to false, you can still use the function `set_display_in_fewbricks_info_pane(true)` on instances of `FieldGroup` to display specific field groups.

- `true` - Display all field groups. This is the default value.
- `false` - Don't display all field groups.

## Example
{: .no_toc }
```php
<?php
add_filter('fewbricks/dev_mode/enable', '__return_false');
```






## fewbricks/settings/install_url
If you have installed Fewbricks somewhere else than in the plugin directory, for example as composer dependency in your theme, Fewbricks need to know that in order to load assets correctly.

## Example
{: .no_toc }
```php
add_filter('fewbricks/settings/install_url', function( $url ) {
    return get_stylesheet_directory_uri() . '/vendor/folbert/fewbricks';
});
```

Note the lack of a trailing slash.




# fewbricks/show_fields_info
Set to `true` to display info about each field in the backend.
This is separated this from the debug-mode filter (described further down) because while you may want to debug, you
may not necessarily want to clutter the backend with field info at the same time.

## Example
{: .no_toc }
```php
add_filter('fewbricks/show_fields_info', '__return_true');
````
