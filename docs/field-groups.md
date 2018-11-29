---
layout: default
title: Field Groups 
nav_order: 40
permalink: /field-groups/
---

# Field Groups

## Settings
In our FieldGroup class we have implemented functions for setting and getting all the settings that are available at
 the time of writing this (ACF v.5.7.7). There is also the generic functions `setSetting()` and `getSetting()` which 
 allows you to use any new settings that ACF introduces without having to wait for Fewbricks to be updated with new 
 getters and setters.
 
 The function names are camelCase versions of ACFs snake_case names. So for example the setting "label_placement" is 
 set by calling `setLabelPlacement('left')`. Note that in some cases the text in the label for an ACF does not 
 directly tell you what the ACF setting is called. The easiest way to find out what the setting is called is by 
 using the filter [fewbricks/dev_tools/show_fields_info](/filters/dev_tools--show_fields_info/). This will display 
 what each setting is actually named by ACF and from that you can quickly calculate what the correspinding function 
 name is called.
 
 ## ---

In most cases, `addField()`, `addFields()` and `addBrick()` (which we will talk more about in general in the
[Bricks-section](doc:bricks) ) will probably do what you need.

Note the function `addFieldSetting()` which allows you to set ACF settings on fields through the Field Group. This
will probably only be used in edge cases but may nevertheless be good to know about.

Pro-tip: since the classes for Field Groups, [Bricks](doc:bricks) and [Shared Fields](doc:shared-fields) all extends
the class FieldCollection, all the ways to add fields shown above can be done when dealing with instances of those
classes.
