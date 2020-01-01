---
parent: Filters
layout: default
title: fewbricks/info_pane/acf_arrays/display_all
nav_order: 10
permalink: /filters/info_pane--acf_arrays--display_all
---

# Filters - fewbricks/info_pane/acf_arrays/display_all

Set whether or not the [Fewbricks Info Pane](/info-pane) (which must be enabled for this filter to have any effect) should display all ACF arrays or not. If you set this to false, you can still use the function `set_display_in_fewbricks_info_pane(true)` on instances of `FieldGroup` to display specific field groups.

- `true` - Display all field groups. This is the default value.
- `false` - Don't display all field groups.

## Example
```php
<?php
add_filter('fewbricks/dev_mode/enable', '__return_false');
```
