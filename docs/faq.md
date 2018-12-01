---
layout: default
title: FAQ 
nav_order: 130
permalink: /faq/
---

# FAQ

## What's up with the weird strings like "1811302108a"?
Those strings are keys that ACF uses. When creating fields and field groups using ACFs GUI, ACF takes care of 
creating those keys for you. Since the keys must be fixed and can not be changed on each load, we have to create 
those keys for ACF when using Fewbricks. 

Field group keys must be unique across all the field groups for a site and, to avoid trouble, field keys should also be 
unique. Fewbricks takes care of checking each key for you to make sure that it is indeed unique and if you should 
create a duplicate key, you will get a `wp_die()`-message. To avoid creating duplicates, the approach that I am 
taking when is to use the current date and time and append a random character to it. So for example on December 24, 
2018 at 1500 hours, I would, based on a date format of YYMMDDHHII, create a key like "1812241500i". That being said, 
you can create your keys by just hammering on a couple of random keys on your keyboard and hope for the best. But if 
you use my approach, you get the bonus of knowing exactly when you wrote the code for each field and field group :) 

If you check the database after you have saved something using fields that was created using Fewbricks, you will see 
that we don't use your key directly but instead prepend it with the key of the field group to which it belongs. If 
you are using bricks, we also include the brick key in the fields keys. If you are using a repeater, we take the 
repeaters key and adds it to the fields key. And so on... This is to ensure that keys will always be unique for 
fields that are reused like they are in for example bricks.

See [ACFs documentation on `acf_add_local_field_group()`](https://www.advancedcustomfields
.com/resources/register-fields-via-php/#group-settings). It states that you must append field group keys with 
"group_" and keys for fields must start with "field_". Fewbricks takes care of that for you if you don't do it yourself.

## Why isn't Fewbricks in the WoprdPress Plugin Directory?
I submitted Fewbricks1 to WordPress in april 2016 but it was rejected. This is the main point copied from the 
rejection mail: 

"At this time, we are not accepting this sort of plugin as we don’t feel frameworks, boilerplates, and libraries are 
appropriate for the Plugins Directory.
 
We do generally require that plugins be useful in and of themselves (even if only being a portal to an external 
service). And while there are many benefits to frameworks and libraries, without plugin dependency support in core or
 the directory, it becomes another level of hassle for users."
 
The complete mail and my thoughts on it are available at [https://github
.com/folbert/fewbricks/issues/2#issuecomment-208723764](https://github.com/folbert/fewbricks/issues/2#issuecomment-208723764). 

## Where's the clone field?
It wouldn't make any sense including the clone field in Fewbricks since that fields only purpose is to clone fields 
which is exactly what Fewbricks allow you to do programmatically. 
