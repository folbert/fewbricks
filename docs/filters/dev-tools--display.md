---
parent: Filters
layout: default
title: dev_tools/display
nav_order: 2
permalink: /filters/dev-tools--display/
---

# Filters - fewbricks/dev_tools/display

```php
<?php
add_filter('fewbricks/dev_tools/display', function() {
    return true;
});
```

## Possible values

- `true` - display dev tools with a start height of "minimized".
- a numeric value between `0` and `100` to use for the css property "vh" on the dev tools main element.
- `false` to not use dev tools at all. This is the default value so you don't have to add the filter at all if this 
is what you want.

Sub filters:

- [fewbricks/dev_tools/acf_arrays/keys](dev-tools--acf-arrays--keys.md)
