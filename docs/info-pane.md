---
layout: default
title: Info Pane
nav_order: 95
permalink: /info-pane/
---

# Info Pane
To help during the development of Fewbricks, I cteated the Fewbricks Info Pane, which may also come in handy when developing with Fewbricks. When activated using the filter [`fewbricks/info_pane/display`](/filters/), an info pane will be displayed at the bottom of your screen. This can be expanded to display info that can help you debugging when using Fewbricks.

## How to use
Besides the filters detailed under [filters](filters/filters.md), you can also interact with the Info Pane in the following ways:

### Force full height
If you have enabled the Info Pane, you can pass "fewbricks-info-pane-height" in the URL as a $_GET variable. For example https://fewbricks.test/?fewbricks-info-pane-height=100. The value should represent the desired height in VH unit. This way, you can work with one window/tab displaying all the debug info and another one (where you have not sent the $_GET variable) displaying for example the admin area where the pane is minimized so you can see what is really going on.

### ACF arrays
This section of the Fewbricks Info Pane will display the arrays that Fewbricks will ultimately pass to [`acf_add_local_field_group()`](https://www.advancedcustomfields.com/resources/register-fields-via-php/).

This section can be toggled using the filter [`fewbricks/info_pane/acf_arrays/display_all`](/filters/info_pane--acf_arrays--display_all)

```php
<?php
$field_group = new \Fewbricks\ACF\FieldGroup('A field group', '1811262137a');
$field_group->set_display_in_fewbricks_info_pane(true);
$field_group->register();
```

If you are using the pane to display ACF arrays, please know that Fewbricks is checking if `dump()` is available and if it is not, falls back to `print_r()`. So I highly recommend installing [var-dumper](https://packagist.org/packages/symfony/var-dumper) to get the most out of the Fewbricks Info Pane.



