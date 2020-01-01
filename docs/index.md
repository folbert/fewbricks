---
layout: default
title: Home
nav_order: 1
permalink: /
---

November 2018: Please note that Fewbricks2 is very much a work in progress. As such, the documentation will change back and forth before the
first non-beta-release.
{: .label .label-red}

# Fewbricks2
{: .no_toc }

- TOC
{:toc}

## Quick example
Want to see some code right away? Start at [Fields](/fields) and continue from there.

## In short, Fewbricks...
- ...is a framework allowing you to write code to create field groups and fields for the awesome WordPress plugin [Advanced Custom Fields v5 Pro](http://www.advancedcustomfields.com/) or ACF for short.
- ...gives you the power to create reusable field collections which we have named [Bricks](/bricks). Check them out, they are pretty neat IMHO.
- ...generates the same kind of arrays that are passed to ACFs `acf_add_local_field_group()` when you use "Generate PHP"
 on the ACF Tools screen. So, sorry to disappoint, there's no black magic in Fewbricks.
- ...is [available at GitHub](https://github.com/folbert/fewbricks) where [issues](https://github
.com/folbert/fewbricks/issues) can be used to ask questions, report bugs and anything else discussed. Pull requests are welcome.
- ...is primarily developed by [Björn Folbert](https://folbert.com), web developer at [KAN](https://kan.se) in Malmö,
Sweden.

## Main concepts

### Portability and re-usability of code
{: .no_toc }
Almost all web sites have a couple of building blocks (modules or "bricks") in common. This can, for example, be "Page hero", "Plain text", "Image with text to the right", "Image with text to the left", "Image", "YouTube-video" and so on. Using a modular system which is completely built using code and split up into single responsibility files instead of storing settings in the database as ACF does out of the box, reusing field groups, fields and bricks across WordPress installs is much easier. Yes, ACF does come with export functionality and ability to generate PHP code but it is still, in my humble opinion, cumbersome to cherry-pick bricks for each project.

### Re-usable field groups
{: .no_toc }
Since, in Fewbricks, all ACF-fields are set up using code, we can reuse fields and even other bricks across multiple bricks. This means that if we need to have, for example, a button in multiple bricks and places, we can create that brick once and then reuse that code all over the place. Now, imagine that the button has multiple settings like giving the administrator the ability to select a style and type (internal link, external link, mail, download etc.) every time a button is used. Having to set that up in multiple times in ACFs visual editor would be a lot of work and you know that the client will want to add new functionality to the button all of a sudden :) Using Fewbricks, all you have to do is change the code in one place. You can even use any of Fewbricks many functions for interacting with Bricks to set up the button brick to behave differently depending on where it is implemented.

Since development on Fewbricks started, the field "Clone" has been introduced in ACF. While this does solve some of the problems that Fewbricks also solves, Fewbricks aims to offer a lot more which you will see later on.

### Extensibility
{: .no_toc }
Since each Brick is a class, you can create a new Brick based on an existing Brick which adds new fields and/or its own output. Or you can add code to an existing Brick to allow anyone who is creating an instance of the class to modify the Brick by passing arguments.

### Cleaner way to output HTML
{: .no_toc }
You can implement one template file for each Brick, which makes figuring out where to edit the output of the brick a breeze. Even if the brick is used in multiple places and loops, the HTML can be edited in one place.

### Code readability
{: .no_toc }
Easier to see which fields belong to a Brick. Instead of having to switch between WordPress Admin and code to see what you named a specific field when you want to use it, you can have it all in one brick class file.
