---
layout: default
title: Dev Tools
nav_order: 9
permalink: /dev-tools/
---

# Dev Tools
To help developing Fewbricks, I created Fewbricks DevTools (FDT), which may also come in handy when developing with 
Fewbricks. By returning `true` for the filter `fewbricks/dev_tools/display`, you will get a dev tool "window" at the 
bottom of your screen. This can be expanded to display info that can help you debugging when using Fewbricks.

## How to use
Besides the filters detailed under [filters](filters/filters.md), you can also interact with FDT in the following ways:

### Force full height
If you have enabled FDT, you can pass "fewbricks-dev-tools-expanded" in the URL as a $_GET variable. For example 
https://fewbricks.test/?fewbricks-dev-tools-expanded. This will trigger FDT to display in expanded mode on page load.
This way, you can work with one window/tab displaying all the debug info and another one (where you have not sent the 
$_GET variable) displaying for example the admin area where FDT is minimized so you can see what is really going on.

### Use settings to display ACF array for specific field groups or fields
By "ACF array", I mean the array that Fewbricks will ultimately pass to `acf_add_local_field_group`.

You can use the filter `fewbricks/dev_tools/acf_arrays/keys` to specify which fields to display info for, where the 
most common use case probably will be to show all field groups. But you can also tell a field group or field 
directly that you want its data to be displayed in FDT. You do this by calling the function `setDisplayInDevTools(true)`
for the field or field group that you want to display.

```php
<?php
$field_group = new \Fewbricks\ACF\FieldGroup('A field group', '1811262137a');
$field_group->setDisplayInFewbricksDevTools(true);
$field_group->register();
```

If you are using FDT to display ACF arrays, please know that Fewbricks is checking if `dump()` is available and if it
 is not, falls back to `print_r()`. So I highly recommend installing
 [var-dumper](https://packagist.org/packages/symfony/var-dumper) to get the most out of FDT.
 


