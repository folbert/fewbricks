# Fewbricks DEV Notes
Notes to Fewbricks Developers (a.k.a. me/Björn Folbert).

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](https://github.com/thlorenz/doctoc)*

- [Testing as both plugin and custom install location](#testing-as-both-plugin-and-custom-install-location)
  - [As composer package in theme](#as-composer-package-in-theme)
    - [Create symlink](#create-symlink)
    - [Remove symlink](#remove-symlink)
  - [As plugin](#as-plugin)
    - [Create symlink](#create-symlink-1)
  - [Remove symlink](#remove-symlink-1)
- [Testing in other environments](#testing-in-other-environments)
- [Documentation](#documentation)
  - [Writing](#writing)
  - [Publishing](#publishing)
- [Release Workflow](#release-workflow)
  - [After release has been created on GitHub:](#after-release-has-been-created-on-github)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Testing as both plugin and custom install location
The Fewbricks repo is placed in a dedicated folder outside of the WordPress-installation and the dev server. We then use symlinks to that folder in order to be able to test running Fewbricks from different locations.

### As composer package in theme

#### Create symlink
vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/ /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/folbert"

#### Remove symlink
vagrant ssh -- -t "cd /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/; unlink folbert"

### As plugin

#### Create symlink
vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/fewbricks/ /var/www/web/app/plugins/fewbricks; ln -s /var/www/___fewbricksrepos___/acf-fewbricks-hidden/ /var/www/web/app/plugins/acf-fewbricks-hidden"

Note that you must enable the plugin as any other WP plugin.

### Remove symlink
vagrant ssh -- -t "cd /var/www/web/app/plugins/; unlink fewbricks; unlink acf-fewbricks-hidden"

## Testing in other environments
We can have multiple test servers set up which, using Composer, pulls branches (feature or release) and tests them.

## Documentation
For easy access to built docs, add a symlink from the web folder to the build site using this command:

`vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/fewbricks/docs/_site/ /var/www/web/docs"`

You can now view the docs at https://fewbricks.test/docs

### Writing
The documentation is written using [Jekyll](https://jekyllrb.com/).
Ruby version is managed using [RBENV](https://github.com/rbenv/rbenv) ([RBENV info in Jekyll documentation](https://jekyllrb.com/docs/installation/macos/#rbenv)).

After you have Jekyll set up, you can use these commands (and [https://jekyllrb.com/docs/usage/](more)).

`bundle exec jekyll serve` to be able to view the site at http://127.0.0.1:4000/ which will rebuild automatically when you edit a MD-file.

`bundle exec jekyll build` which will build the site and prepare it for deploy.


### Publishing
Use the publish script located in the docs folder to rsync to https://fewbricks2.folbert.com

## Release Workflow
These are notes to make sure that I don't forget anything when creating a new release.

Version numbering follows [Semantic Versioning](http://semver.org/).

1. Describe new version in changelog.md
2. Change version nr in comment in fewbricks.php
3. Change version nr for $plugin_current_version in fewbricks.php

After master has been pushed, create release on GitHub.

### After release has been created on GitHub:

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

