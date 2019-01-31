---
parent: Fields
layout: default
title: Extensions 
nav_order: 50
permalink: /fields/extensions/
---

# Fields - Extensions
Fewbricks comes with support for all fields available in ACF except the clone field (check the [FAQ](/faq/) if you 
want to know why) and some extensions that we use ourselves. But maybe you have found an extension at, for example
[https://awesomeacf.com/](Awesome ACF) or maybe you have [written a new field type](https://www.advancedcustomfields.com/resources/creating-a-new-field-type/) yourself? Either way, if you want to use a field type that is not supported
by Fewbricks, you will need to write some custom code for it to work with Fewbricks. Check 
[src/ACF/Fields/Extensions/_template.php](https://github.com/folbert/fewbricks/tree/2
.x/src/ACF/Fields/Extensions/_template.php) for full code and what you can do.

Note that some extensions are not testing if settings are set before using their names as indexes in arrays which will cause fatal errors. Check the code for [AcfCodeField](https://github
.com/folbert/fewbricks/tree/2.x/src/ACF/Fields/Extensions/AcfCodeField.php) on how we fix that by implementing the 
`to_acf_array`-function in the field class.
 


## Supported extensions in Fewbricks core
Fewbricks comes with field classes to support the extensions listed below. Note that you have to install the 
extension before using the corresponding Fewbricks class for it.

- [Code Field](https://wordpress.org/plugins/acf-code-field/)
- [Dynamic Year Select](https://wordpress.org/plugins/acf-dynamic-year-select-field/)
- [Table Field](https://wordpress.org/plugins/advanced-custom-fields-table-field/)
