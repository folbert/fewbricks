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

### Install using Composer
Fewbricks is available at Packagist at [https://packagist.org/packages/folbert/fewbricks](https://packagist .org/packages/folbert/fewbricks). Please see the link to find which version is the latest and which one you want to tell Composer to require.

Requiring 2.0 looks like this:
```bash
composer require folbert/fewbricks:2.0
```

Activate the newly installed plugins Fewbricks and Fewbricks Hidden Field for ACF like you would any other WordPress plugin. This is not necessary if Fewbricks is placed for example in the themes directory.

The repository type of the package is "wordpress-plugin" which may be good to know since you will probably want Fewbricks to end up in the plugins directory and not in the default vendor directory for Composer packages (although you can install Fewbricks anywhere as long as you [/filters/settings--install_url/](tell it where to find itself)). If you want to get started using Composer with WordPress and potentially stepping your WP game up in lots of other ways, I highly recommend using [Bedrock](https://roots.io/bedrock/) from the team behind [Roots/Sage](https://roots.io/) .

*Note that even if you are installing Fewbricks this way, you still need to make sure that Fewbricks Hidden Field for ACF is activated. You can get Fewbricks Hidden Field from [Packagist](https://packagist.org/packages/folbert/acf-fewbricks-hidden).*

### Install manually
Please note that Fewbricks2 can not be updated using standard update actions in the WP admin area. This is because I want to focus on Composer and minimize the actions to take and mistakes to make when creating releases.

1. If you are installing Fewbricks the good old manual way, you must first install the plugin [Fewbricks Hidden field for ACF](https://github.com/folbert/acf-fewbricks-hidden) and make sure that its folder is named "acf-fewbricks-hidden". So head on over to GitHub and get the zip with the [https://github.com/folbert/acf-hidden/releases](latest version of Fewbricks Hidden Field).
2. Download the latest [release of Fewbricks](https://github.com/folbert/fewbricks/releases).
3. Install and activate Fewbricks Hidden Field and Fewbricks like you would any other WordPress plugin.

## After initial install
Note that these steps does not have to be done on each update of Fewbricks, only the first time you install it.

### Running demo code
If this is your first time running Fewbricks2, you may want to check out the demo code to see what you can do with
what you just installed. In the fewbricks-folder in plugins, you will find a folder named "fewbricks-demo". Copy or
move that folder to, for example, your themes folder. Then require the init.php-file found in the folder you just copied.

You should now, if all has gone as planned, see the post types "Fewbricks Demo Pages Type 1" and "Fewbricks Demo
pages Type 2" in the admin area.

@todo Describe action fewbricks/init

```php
add_action('fewbricks/init', function() {

  // Kick off your Fewbricks code here.

});
```

Let's go to [Fields](/fields/) to get some code.
