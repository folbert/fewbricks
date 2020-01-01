---
parent: Filters
layout: default
title: fewbricks/settings/install_url
nav_order: 85
permalink: /filters/settings--install_url/
---

# Filters - fewbricks/settings/install_url

If you have installed Fewbricks somewhere else than in the plugin directory, for example as composer dependency in your theme, Fewbricks need to know that in order to load assets correctly.

## Example

```php
add_filter('fewbricks/settings/install_url', function( $url ) {
    return get_stylesheet_directory_uri() . '/vendor/folbert/fewbricks';
});
```

Note the lack of a trailing slash.
