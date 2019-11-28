---
parent: Filters
layout: default
title: settings/url
nav_order: 85
permalink: /filters/settings--url/
---

# Filters - fewbricks/templater/brick_templates_base_path

If you have installed Fewbricks somewhere else than in the plugin directory, for example as composer dependency in your theme, Fewbricks need to know that in order to load assets correctly.

For example:

```php
add_filter('fewbricks/settings/url', function( $url ) {
    return get_stylesheet_directory_uri() . '/vendor/folbert/fewbricks';
});
```

Note the lack of a trailing slash. Should you happen to add one, Fewbricks will remove it for you.
