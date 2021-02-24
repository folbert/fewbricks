# Fewbricks DEV Notes
Notes to Fewbricks Developers (a.k.a. me/Björn Folbert).

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](https://github.com/thlorenz/doctoc)*

- [Testing as both plugin and custom install location](#testing-as-both-plugin-and-custom-install-location)
  - [Test as composer package in theme](#test-as-composer-package-in-theme)
    - [Create symlinks](#create-symlinks)
    - [Remove symlinks](#remove-symlinks)
  - [Test as plugin](#test-as-plugin)
    - [Create symlinks](#create-symlinks-1)
  - [Remove symlinks](#remove-symlinks-1)
- [Testing in other environments](#testing-in-other-environments)
- [Documentation](#documentation)
  - [Writing](#writing)
  - [Testing](#testing)
  - [Publishing](#publishing)
- [Release Workflow](#release-workflow)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Testing as both plugin and custom install location
In the development environment, the Fewbricks and Fewbricks Hidden repos are placed in a dedicated folder outside of the WordPress-installation and the dev server. We then use symlinks to that folder in order to be able to test running Fewbricks from different locations.

### Test as composer package in theme

#### Create symlinks
vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/ /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/folbert"

#### Remove symlinks
vagrant ssh -- -t "cd /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/; unlink folbert"

### Test as plugin

#### Create symlinks
vagrant ssh -- -t "ln -s /home/vagrant/code/___fewbricksrepos___/fewbricks/ /home/vagrant/code/web/app/plugins/fewbricks; ln -s /home/vagrant/code/___fewbricksrepos___/acf-fewbricks-hidden/ /home/vagrant/code/web/app/plugins/acf-fewbricks-hidden"

Note that you must enable the plugin as any other WP plugin.

### Remove symlinks
vagrant ssh -- -t "cd /home/vagrant/code/web/app/plugins/; unlink fewbricks; unlink acf-fewbricks-hidden"

## Testing in other environments
We can have multiple test servers set up which, using Composer, pulls branches (feature or release) and tests them.

## Documentation

### Writing
The documentation is written using [Jekyll](https://jekyllrb.com/).
Ruby version is managed using [RBENV](https://github.com/rbenv/rbenv) ([RBENV info in Jekyll documentation](https://jekyllrb.com/docs/installation/macos/#rbenv)).

After you have Jekyll set up, head into the docs folder and use these commands (and [https://jekyllrb.com/docs/usage/](more)).

`bundle exec jekyll serve` to be able to view the site at http://127.0.0.1:4000/ which will rebuild automatically when you edit a MD-file.

`bundle exec jekyll build` which will build the site and prepare it for deploy.

### Testing
For easy access to built docs, add a symlink from the web folder to the built site using this command:

`vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/fewbricks/docs/_site/ /var/www/web/fewbricks-docs"`

If the server command above has been executed, you can now view the docs at https://[DOMAIN]/fewbricks-docs.

To remove the symlink
`vagrant ssh -- -t "cd /var/www/web/; unlink fewbricks-docs"`

### Publishing
Use the publish script located in the docs folder to rsync to https://fewbricks2.folbert.com

``

## Release Workflow
These are notes to make sure that I don't forget anything when creating a new release.

Version numbering follows [Semantic Versioning](http://semver.org/).

1. Describe new version in CHANGELOG.md
2. Change version nr in comment in fewbricks.php
3. Change FEWBRICKS_VERSION in lib/Fewbricks.php

Create release locally and push.

After master has been pushed, create release on GitHub.

Start version number with a "v".

Update https://version.fewbricks2.folbert.com/version-info.php with the correct data

