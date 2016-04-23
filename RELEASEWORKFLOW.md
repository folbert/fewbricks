# Release Workflow
These are notes to make sure that Fewbricks developers doesn't forget anything when creating a new release. 

Version number follows [Semantic Versioning](http://semver.org/)

## Git-Flow in Tower
[https://www.git-tower.com/learn/git/ebook/en/mac/advanced-topics/git-flow](https://www.git-tower.com/learn/git/ebook/en/mac/advanced-topics/git-flow)

## After release has been created on GitHub:

These steps are to make sure that a notice about the new version is displayed when listing plugins in the WordPress admin system.

* Download Zip from [https://github.com/folbert/fewbricks/releases](https://github.com/folbert/fewbricks/releases)
* Create directory "fewbricks"
* Put zip in "fewbricks" directory
* Unzip
* Rename unzipped dir to "fewbricks"
* Remove .gitignore from unzipped dir
* Zip parent dir so you now have a Zip named "fewbricks" with a dir named "fewbricks"
* Upload to fewbricks.folbert.com/update/zips/[version-nr]/
* Edit update.php:
    *  Update $obj->new_version
    * Update $obj->last_updated
    * Check $obj->tested
    * Check $obj->requires
* Save
* Check folbert.com and force a plugin update check to make sure changes are correct