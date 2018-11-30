---
layout: default
title: Field Groups 
nav_order: 40
permalink: /field-groups/
---

# Field Groups

## Settings
In Fewbricks FieldGroup class we have implemented getters and setters for all the ACF settings that are available at the
time of writing this (ACF v.5.7.7). You can also use the generic functions `setSetting()` and `getSetting()` to set 
and get any new settings that ACF introduces without having to wait for Fewbricks to be updated with new getters and 
setters.
 
The function names are camelCase versions of ACFs snake_case names. So for example the setting "label_placement" is 
set by calling `setLabelPlacement('value')` and "Description" is set by `setDescription()`. Most of the times you will
be able to calculate the name that ACF stores a setting under by looking at the (english) label in ACFs GUI when 
creating a field group. For example "Active" is stored under "active" which in turn can be set in Fewbricks by 
calling `setActive(true)` (or `setActive(false)`). There are however some cases where the label does not directly 
corresponds to you what the ACF setting is called. An example of this is "Order" which ACF stores as "menu_order" 
which corresponds to `setMenuOrder()` in Fewbricks. The easiest way to find out what the setting is called is by 
using the filter [fewbricks/dev_tools/show_fields_info](/filters/dev_tools--show_fields_info/). This will display what 
each setting is actually stored as by ACF.
 
 ## ---

In most cases, `addField()`, `addFields()` and `addBrick()` (which we will talk more about in general in the
[Bricks-section](doc:bricks) ) will probably do what you need.

Note the function `addFieldSetting()` which allows you to set ACF settings on fields through the Field Group. This
will probably only be used in edge cases but may nevertheless be good to know about.

Pro-tip: since the classes for Field Groups, [Bricks](doc:bricks) and [Shared Fields](doc:shared-fields) all extends
the class FieldCollection, all the ways to add fields shown above can be done when dealing with instances of those
classes.
