---
parent: Filters
layout: default
title: fewbricks/dev_mode/enable
nav_order: 1
permalink: /filters/dev_mode--enable/
---

# Filters - fewbricks/dev_mode/enable
Enable/disable [Dev Mode](/dev-mode).

## Possible values
- `false` - disables Dev Mode. This is the default value.
- `true` - enables Dev Mode.

## Example
```php
<?php
add_filter('fewbricks/dev_mode/enable', '__return_true');
```
