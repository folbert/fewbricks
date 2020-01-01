---
parent: Filters
layout: default
title: info_pane/acf_array/keys
nav_order: 10
permalink: /filters/info_pane--keys/
---

# Filters - fewbricks/info_pane/acf_arrays/keys

```php
fewbricks/info_pane/acf_arrays/keys
```

`true` - Display all field groups

`string` - Set a key for the field group, field or brick to display.

`array` - An array of keys.

Note that since Febwricks adds "group_" or "field_" prefix to the keys you send to it, you have to prefix the key
you send to this filter with the correct prefix. Use the filter
[`show_fields_info`]
('show-fields-info.md') to see the key for the item(s) you want to display.
