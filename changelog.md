# Fewbricks changelog

## 1.4.0 - May 7, 2016
* Added functions get_brick_layouts() and has_brick_layout() for brick class.
* Added hook for filter fewbricks/brick/brick_template_base_path in brick->get_brick_template_html(). More info in the readme file.
* helpers\hide_acf_info() now returns correct value

## 1.3.0 - April 29, 2016
* Added functions for setting/retrieving inline css for a brick. This can come in handy if you want to set some styles dynamically in a brick that a brick layout should have access to. Seach the readme for "inline_css" for more info.
* Improvements on `set_data_item()` in [the brick class](lib/brick.php) and added `get_data_item()` . You can now group data. Search the readme for "set_data_item" for more info.
* Added `get_key()` to brick class.

## 1.2.0 - April 23, 2016
* Added support for placing fewbricks in child theme

## 1.1.1 - April 24, 2016
* Hotfix for Timber dependency in demo 

## 1.1.0 - April 23, 2016
* Added autoupdate functionality when viewing the plugin in plugins list.

## 1.0.1 - April 23, 2016
* Fixed bug with incorrect path to custom field classes in template
* Added the changelog
* Object orientified the bootstrap file
* Updates to the Readme file

## 1.0 - April 22, 2016
* First stable release