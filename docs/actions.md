---
layout: default
title: Actions
nav_order: 105
has_children: true
permalink: /actions/
---

# Actions
{: .no_toc }

## Table of contents
{: .no_toc .text-delta }

- TOC
{:toc}

## fewbricks/init

This action is triggered when Fewbricks is ready and you can start using it. Since Fewbricks core code is executed on the action `acf/init`, you can be sure of that both ACF and Fewbricks is fully ready on `fewbricks/init`.

### Example
{: .no_toc }
{
```php
add_action('fewbricks/init', function() {

    new Text('Text field', 'text_field', '2002142304a');

    // ...and more code here...

});
```
