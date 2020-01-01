---
parent: Filters
layout: default
title: info_pane/display
nav_order: 20
permalink: /filters/info_pane--display/
---

# Filter - fewbricks/info_pane/display

Set whether you want to display the [Fewbricks Info Pane](/info-pane) or not. Defaults to `false`.

## Possible values

- `false` to not display the info pane at all. This is the default value so you don't have to add the filter at all if this
is what you want.
- `true` - display the info pane with a start height of "minimized".
- a numeric value between `0` and `100` to use for the css property "vh" on the info pane main element.

## Example
```php
<?php
add_filter('fewbricks/info_pane/display', function() {
    return true;
});
```
