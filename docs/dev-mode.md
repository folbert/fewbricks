---
layout: default
title: Dev Mode
nav_order: 90
permalink: /dev-mode/
---

# Dev Mode

Dev Mode is enabled using the filter [fewbricks/dev_mode/enable](/filters/dev_mode--enable).

Dev Mode enables code that may take some extra time, however small, to execute and Dev Mode should therefore not be enabled in production environments.

When Dev Mode is enabled, Fewbricks will:

- Checks field names for max length. Due to WordPress' database scheme, meta_key values in the _postmeta table can
not exceed 255 characters. Since Fewbricks is prefixing the names that you give fields if the field is used in
Bricks, it is possible, although unlikely, that the field name will ultimately end up exceeding that limit. If it
does and Dev Mode is enabled, Fewbricks will trigger `wp_die` and tell you all about it.

- Checks for duplicate keys. This is always done when adding a field to a field group, brick, repeater etc. In dev
mode, Fewbricks performs an extra check after the array to send to ACF has been created and all field keys have been
prefixed with parents.



