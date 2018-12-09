---
layout: default
title: Getting started 
nav_order: 30
permalink: /getting-started/
---

# Getting started

## Meeting the requirments
Make sure that your setup meets the [requirements](/requirements/).

## Installing
Fewbricks can be installed either by using Composer or doing an old fashioned manual install. Regardless of which o
the ways you choose, there are some common steps to be taken after the initial install so make sure you don't miss 
the instructions below the manual installation steps.

### Install using Composer
Note that even if you are installing Fewbricks this way, you still need to make sure that Fewbricks Hidden Field for 
ACF is installed and activated. You can get Hidden from [Packagist](https://packagist.org/packages/folbert/acf-fewbricks-hidden).

Fewbricks is available at Packagist at [https://packagist.org/packages/folbert/fewbricks](https://packagist
.org/packages/folbert/fewbricks). Please see the link to find which version is the latest and which one you want to 
tell Composer to require.

Requiring 2.0 looks like this:
```bash
composer require folbert/fewbricks:2.0
```

The repository type of the package is "wordpress-plugin" which may be good to know since you will want Fewbricks to
end up in the plugins directory and not in the default vendor directory for Composer packages. If you want to get
started using Composer with WordPress and potentially stepping your WP game up in lots of other ways, I highly
recommend using [Bedrock](https://roots.io/bedrock/) from the team behind [Roots/Sage](https://roots.io/) .

### Install manually
1. If you are installing Fewbricks the good old manual way, you must first install the plugin [Fewbricks Hidden field
for ACF](https://github.com/folbert/acf-fewbricks-hidden) and make sure that its folder is named 
"acf-fewbricks-hidden". So head on over to GitHub and get the zip with the [https://github
.com/folbert/acf-hidden/releases](latest version of Fewbricks Hidden Field).
2. Download the latest [release of Fewbricks](https://github.com/folbert/fewbricks/releases).
3. Install and Hidden and Fewbricks like you would any other WordPress plugin.

## After initial install
Note that these steps does not have to be done on each update of Fewbricks, only the first time you install it.

Activate the newly installed plugins Fewbricks and Fewbricks Hidden Field for ACF like you would any other WordPress
plugin.

### Running demo code
If this is your first time running Fewbricks2, you may want to check out the demo code to see what you can do with 
what you just installed. In the fewbricks-folder in plugins, you will find a folder named "fewbricks-demo". Copy or 
move that folder to, for example, your themes folder. Then require the init.php-file found in the folder you just copied.

You should now, if all has gone as planned, see the post types "Fewbricks Demo Pages Type 1" and "Fewbricks Demo 
pages Type 2" in the admin area.

@todo Describe action fewbricks/init

~~~The first thing you want to do is to tell Fewbricks that the code you are going to write for it will not be 
located at
plugins/fewbricks/fewbricks-demo which is the default location. This is because if you kept your custom code in the
Fewbricks core directory, it would be overwritten on the next plugin update. So let's keep your custom code somewhere
safe. It may be in a functionality plugin or in your theme or any other place you prefer. Wherever you place the
files, you need to tell Fewbricks where they are by using the filter [set_brick_template_base_path]
(doc:set-brick-template-base-path).~~

~Let's assume that you are going to keep all the custom Fewbricks code in a directory called "project-fewbricks" in the
directory of the theme you are developing. You would then add this to one of your theme files (for example `function
.php`).~~~

```php
<?php

add_filter('fewbricks/project_files_base_path', function() {
  return get_template_directory() . '/project-fewbricks';
});
```
~~If you want to, feel free to copy the directory plugins/fewbricks/fewbricks-demo to project-fewbricks. This will give
you some example code to play around with. You will also get code for an auto loader that you can keep, edit or
delete as you see fit. The rest of the documentation will assume that you have auto-loading in place in one way or
another.~~
 
~~Make sure that there is a file named fewbricks-init.php in the root of the directory where your custom
Fewbricks files will reside.~~
