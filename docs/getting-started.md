---
layout: default
title: Getting started
nav_order: 30
permalink: /getting-started/
---

# Getting started
{: .no_toc }

## Table of contents
{: .no_toc .text-delta }

- TOC
{:toc}

## Meeting the requirements
Make sure that your setup meets the [requirements](/requirements/).

## Installing
Fewbricks 2 is not available in the WordPress Plugin Repository. When Fewbricks 1 was released, I submitted it but [it was rejected](/faq/#why-isnt-fewbricks-in-the-wordpress-plugin-directory) which I am perfectly fine with.

Please note that Fewbricks2 can not be updated using standard update actions in the WP admin area. This is because I want to focus on Composer and minimize the actions to take and mistakes to make when creating releases.

### Install using Composer
{: .no_toc }
Fewbricks is available at [https://packagist.org/packages/folbert/fewbricks](https://packagist.org/packages/folbert/fewbricks). Please see the link to find which version is the latest and which one you want to tell Composer to require.

Requiring 2.0 would looks like this:
```bash
composer require folbert/fewbricks:2.0
```

This will take care of also installing Advanced Custom Fields: Hidden Field for Fewbricks.

The repository type of the package is "wordpress-plugin" which may be good to know since you will probably want Fewbricks to end up in the plugins directory and not in the default vendor directory for Composer packages (although you can install Fewbricks anywhere as long as you [/filters/settings--install_url/](tell it where to find itself)). If you want to get started using Composer with WordPress and potentially stepping your WP game up in lots of other ways, I highly recommend using [Bedrock](https://roots.io/bedrock/) from the team behind [Roots/Sage](https://roots.io/) .

### Other install methods
{: .no_toc }
1. If you are installing Fewbricks the old manual way, you must first install the plugin [Fewbricks Hidden field for ACF](https://github.com/folbert/acf-fewbricks-hidden) and make sure that its folder is named "acf-fewbricks-hidden". So head on over to GitHub and get the zip with the [https://github.com/folbert/acf-hidden/releases](latest version of Fewbricks Hidden Field).
2. Download the latest [release of Fewbricks](https://github.com/folbert/fewbricks/releases).
3. Install Fewbricks Hidden Field and Fewbricks like you would any other WordPress plugin.

## After initial install
Note that these steps does not have to be done on each update of Fewbricks, only the first time you install it.

Activate the newly installed plugins Fewbricks and Fewbricks Hidden Field for ACF like you would any other WordPress plugin. This is not necessary if Fewbricks is placed for example in the themes directory.

## Next step
Let's go to [Fields](/fields/) to check out some code.
