---
parent: Filters
layout: default
title: dev_mode
nav_order: 1
permalink: /filters/dev_mode/
---

# Filters - fewbricks/dev-mode

```php
fewbricks/dev-mode
```

Set to `true` to carry out actions that should only be done in developing environments due to unnecessary server load:

- Checks field names for max length. Due to WordPress' database scheme, meta_key values in the _postmeta table can 
not exceed 255 characters. Since Fewbricks is prefixing the names that you give fields if the field is used in 
Bricks, it is possible, although unlikely, that the field name will ultimately end up exceeding that limit. If it 
does, Fewbricks will cause `wp_die` and tell you all about it.

- Checks for duplicate keys. This is always done when adding a field to a field group, brick, repeater etc. In dev 
mode, Fewbricks performs an extra check after the array to send to ACF has been created and all field keys have been
prefixed with parents. This check is probably redundant but exists just in case.

Set to `false` to disable all of the above.
