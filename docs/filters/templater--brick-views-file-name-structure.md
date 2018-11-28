---
parent: Filters
layout: default
title: templater/brick_views_file_name_structure
nav_order: 9
permalink: /filters/templater--brick-views-file-name-structure/
---

# Filters - fewbricks/templater/brick_views_file_name_structure

You only need to care about this filter if you intend to use [Fewbricks simple template engine](/bricks/templates/).
If you don't, you can ignore this.

This filter allows you to define a string to add between the part of the file which is created in 
Fewbricks\Templating\Helper::getBrickTemplateFileName() and the required file ending ".php".

Defaults to ".view" to create the file name "image-and-text.view.php" for a brick whose class name is "ImageAndText".

Note that you can also use the filter
[fewbricks/templater/brick_template_file_name](filters/templater--brick-template-file-name) to completely change the 
file name structure or even for a specific brick.
