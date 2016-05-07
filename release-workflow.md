# Release Workflow
These are notes to make sure that Fewbricks developers doesn't forget anything when creating a new release. 

Version number follows [Semantic Versioning](http://semver.org/)

* Describe new version in changelog.md 
* Change version nr in comment in fewbricks.php
* Change version nr for $plugin_current_version in fewbricks.php

## Git-Flow in Tower
[https://www.git-tower.com/learn/git/ebook/en/mac/advanced-topics/git-flow](https://www.git-tower.com/learn/git/ebook/en/mac/advanced-topics/git-flow)

Don't prefix tags with "v" since the repo was set up to auto prefix tags with "v".

After master has been pushed, create release on GitHub.

## After release has been created on GitHub:

These steps are to make sure that a notice about the new version is displayed when listing plugins in the WordPress admin system.

* Download Zip from [https://github.com/folbert/fewbricks/releases](https://github.com/folbert/fewbricks/releases)
* Unzip
* Remove .gitignore from unzipped dir
* Rename directory to "fewbricks" 
* Re-Zip
* Upload to fewbricks.folbert.com/update/zips/[version-nr]/
* Edit update.php:
    * Update $obj->new_version
    * Update $obj->package
    * Update $obj->last_updated
    * Check $obj->tested
    * Check $obj->requires
* Save
* Check folbert.com and force a plugin update check to make sure changes are correct