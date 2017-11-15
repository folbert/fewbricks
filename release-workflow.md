# Release Workflow
These are notes to make sure that Fewbricks developers doesn't forget anything when creating a new release. 

Version numbering follows [Semantic Versioning](http://semver.org/).

1. Describe new version in changelog.md 
2. Change version nr in comment in fewbricks.php
3. Change version nr for $plugin_current_version in fewbricks.php

After master has been pushed, create release on GitHub.

## After release has been created on GitHub:

These steps are to make sure that a notice about the new version is displayed when listing plugins in the WordPress admin system.

1. Download Zip from [https://github.com/folbert/fewbricks/releases](https://github.com/folbert/fewbricks/releases)
2. Unzip
3. Remove .gitignore from unzipped dir
4. Rename directory to "fewbricks" 
5. Re-Zip
6. Upload to fewbricks.folbert.com/update/zips/[version-nr]/
7. Edit update.php:
    1. Update $obj->new_version
    2. Update $obj->package
    3. Update $obj->last_updated
    4. Check $obj->tested
    5. Check $obj->requires
8. Save
9. Check folbert.com and force a plugin update check to make sure changes are correct
