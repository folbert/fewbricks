---
parent: Filters
layout: default
title: dev_tools/acf_array/keys
nav_order: 3
permalink: /filters/dev_tools--keys/
---

# Filters - fewbricks/dev_tools/acf_arrays/keys

```php
fewbricks/dev_tools/acf_arrays/keys
```

`true` - Display all field groups

`string` - Set a key for the field group, field or brick to display.

`array` - An array of keys.

Note that since Febwricks adds "group_" or "field_" prefix to the keys you send to it, you have to prefix the key 
you send to this filter with the correct prefix. Use the filter 
[`show_fields_info`]
('show-fields-info.md') to see the key for the item(s) you want to display.
