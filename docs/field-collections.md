---
layout: default
title: Field Collections 
nav_order: 70
permalink: /field-collections/
---

# Field collections

Field Groups and Bricks are child classes of the class `FieldCollection´. Repeaters, layouts (used by Flexible Content) and Groups each have a class variable that is an instance of the same class.

## Adding fields

### Add field collection
`addFieldCollection($fieldCollection)` lets you add another instance of the FieldCollection class. When this is
done, `prepareForAcfArray()` is applied on the added collection. This will make sure that any fields that should be
removed or injected are taken care of. It also prefixes keys, labels and names as needed. After that, the field
objects of the passed collection are added to the receiving collection and considered "first class citizens" with no
connection to collection they were part of before being added to the new collection.
