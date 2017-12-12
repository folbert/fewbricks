# Fewbricks

Please see [this issue](https://github.com/folbert/fewbricks/issues/2#issuecomment-208723764) on why Fewbricks is not in the WordPress Plugin Directory.

## TOC
+ [Legal](#legal)
+ [Dictionary](#dictionary)
+ [About](#about)
+ [Requirements](#requirements)
+ [Installation](#installation)
+ [Demo](#demo)
+ [Usage](#usage)
    + [Fields](#fields)
    + [Creating a brick](#creating-a-brick)
        + [Creating a standard brick](#creating-a-standard-brick)
        + [Is that all Fewbricks can do?](#is-that-all-fewbricks-can-do)
    + [Important about naming fields](#important-about-naming-fields)
    + [Brick layouts](#brick-layouts)
    + [Fewbricks specific settings for fields and bricks](#fewbricks-specific-settings-for-fields-and-bricks)
    + [CSS](#css)
    + [Developer mode](#developer-mode)
        + [Field info](#field-info)
    + [ACF Local JSON](#acf-local-json)
        + [Important about local JSON](#important-about-local-json)
    + [Available fields](#available-fields)
    + [Filters](#filters)
        
        
## Legal
Fewbricks and its developers are in no way associated with Advanced Custom Fields. Fewbricks is released under GPLv3.

## Dictionary
The following words will be explained in detail later in this document,

+ Field - Same as in ACF. For example text, textarea, select, true/false, flexible content etc.
+ Brick - A collection of fields.
+ Brick Layout - Not to be confused with ACFs layouts. Brick layouts are like layouts in the [Blade templating system](https://laravel.com/docs/5.2/blade#defining-a-layout).

## About
Fewbricks is a module system developed by [Björn Folbert](https://folbert.com) at [KAN Malmö](http://kan.se). It is built on top of the awesome plugin [Advanced Custom Fields](http://www.advancedcustomfields.com/) (ACF) v5 PRO meaning that you must have that installed for this to work.

Instead of building field groups, repeaters, flexible content etc. using the GUI that comes with ACF, you build it all by writing code. So if you are looking for a way to create reusable fields within the GUI, Fewbricks is not what you are looking for.

Field groups, flexible content, repeaters and fields. All of those are names that you recognize from ACF and they are all available in Fewbricks as well. Just as in ACF, you create a field group and then you add some fields to it. If the field is a flexible content, you will add layouts to it. If you are creating a repeater, throw a couple of sub fields in there. All just as you would if you were creating field groups using ACFs GUI. But Fewbricks also gives you the ability to reuse bricks across multiple field groups and/or flexible contents and/or repeaters.

The code that you write using Fewbricks will in the end render the same arrays that are passed to `acf_add_local_field_group()` in the code that is generated when you use "Generate export code" on the ACF Tools screen.

The system was created for the following reasons:
 
 * Portability and reusability. Almost all web sites have a couple of building blocks (bricks or modules) in common. This can, for example, be "plain text", "image with text to the right", "image with text to the left", "image", "YouTube-video" and so on. Using a module system which is completely built using code (instead of storing settings in the database as ACF does out of the box) we can reuse such bricks without setting them up every time we set up a new site. Yes, ACF does come with the export functionality but it is still cumbersome to cherrypick bricks for each project.
 
 * Flexible ACF. This is probably the most important, and also the original, reason as to why this system was created. Since, in Fewbricks, all ACF-fields are set up using code, we can reuse fields and even other bricks across multiple bricks. This means that if we need to have, for example, a button in multiple bricks and places, we can create that brick once and then reuse that code all over the place. Now, imagine that the button have multiple settings and must give the administrator the ability to select a style and a functionality (internal link, external link, mail, download etc.) every time a button is used. Having to set that up in multiple times in ACFs visual editor would be a lot of work and you know that the client will want to add new functionality to the button all of a sudden :)
 
 * Cleaner way to output HTML. By having each brick outout its own HTML, figuring out where to make changes in a brick becomes a breeze. Even if the brick is used in multiple places and loops, the HTML is edited in one place.
 
 * Easier to see what fields belong to a brick. Instead of having to switch between WP Admin and code to see what you named a specific field, you have it all in one brick class file.
 
 * Extensibility. Since each brick is a class, we can easily create a new brick which adds new fields and/or its own output. 
 
## Requirements
 *  PHP 5.4+
 
 *  [Advanced Custom Fields](http://www.advancedcustomfields.com/) 5+ PRO
 
 *  [Fewbricks Hidden Field for Advanced Custom Fields](https://github.com/folbert/acf-fewbricks-hidden) This allows us to store settings in a brick. For example how many columns a multi column brick should have.
 
 * Fewbricks also supports [Timber](http://upstatement.com/timber/) but having that installed is not a requirement
 
 *  Some experience with ACF and knowledge about what a field, field group etc is is recommended and that can all be read up on in the [documentation for ACF](http://www.advancedcustomfields.com/resources).
 
## Installation
 1. Make sure that the [requirements](#requirements) are met.
 
 2. Add Fewbricks to your plugin folder using one of the following techniques
 
    * Install using Composer 
    > composer require folbert/fewbricks
    
    I have set the repository type of the package to "wordpress-plugin" which may be good to know since you will want Fewbricks to end up in the plugins directory and not in the default vendor directory for Composer packages. If you want to get started using Composer with WordPress (and potentially stepping your WP game up in lots of other ways, I highly recommend using [Bedrock](https://roots.io/bedrock/) from the team behind Roots/[Sage](https://roots.io/sage/))
     
    * Install manually by downloading [the latest release](/releases).
    If you are installing Fewbricks this way, you must also install [Fewbricks Hidden field for ACF](https://github.com/folbert/acf-fewbricks-hidden) and make sure that its folder is named "acf-fewbricks-hidden".
 
 3. In the main folder named "fewbricks", there is a folder also named "fewbricks". Move that folder to either the plugins folder or your theme folder. If you place it in the theme fodler and keep the name "fewbricks", you don't have to do anything. If you place the directory anywhere else and/or rename it, check the filter `fewbricks/project_files_base_path` to let Fewbricks know your custom path. All your custom code will reside in this folder. When starting writing Febwricks, i thought that keeping the it in the theme directory was the best thing to do, but have since come to change my mind and now prefer to keep it the plugins directory. For the sake of backwards compatibility, the default location is still themes/[theme-name]/fewbricks. 
 
 4. Activate Fewbricks and "Advanced Custom Fields: Hidden Field for Fewbricks" as you would any other plugins.
 
 __Important__ 
 When you move the directory in step 3 it gets completely disconnected from any future updates to Fewbricks. This is all good since you are gonna want to create your own field groups, bricks, brick layouts and so on. It may be that we add some new demos to the fewbricks/fewbricks directory but that will not affect your custom code in any way and you should never overwrite your [theme]/fewbricks with an updated fewbricks/fewbricks.
     
 Do not delete or rename any of these files and folder in [theme]/fewbricks/:
 
 * acf/
 * brick-layouts/
 * bricks/
 * common-fields
 * field-groups/
 * field-groups/init.php
 * common-fields/init.php
 * bricks/project-brick.php - This file have a couple of functions prefixed with "demo". Keep those functions as long as you want the demo to work. After that, feel free to delete them.
 
 Also as long as you want the demos to work, keep all files prefixed with "demo". As for the folder named "demo"; read about that under [Demo](#demo) further down in this document.
 
 Other than that, feel free to delete all other files or add new files and folders as you see fit.
 
## Demo
After having carried out the installation steps, you can set up the demo by following these steps:
  
1. Move [theme]/fewbricks/demo/template-fewbricks-demo.php to the root of your theme folder. Please note that this template is completely standalone and does not include any WP head or your themes stylesheets. This is only because it is a demo and we want to make sure we have a clean Bootstrap page to work with.

2. Go to the admin area of WordPress, create a new page and select the template "Fewbricks Demo".

3. You should now, instead of the standard WYSIWYG area, see a bunch of fields and buttons that looks like the standard ACF GUI. If you don't, hit "Update"/"Publish".

4. What you see is standard ACF fields that have been put there using Fewbricks. Head on over to [theme]/fewbricks/field-groups/init.php to start tracking what is going on and how everything works.

5. Play around with adding some data to fields and adding flexible content etc.

6. Hit "Update" and go to the frontend to see what you have created.

7. If you have not already done so, have a look at the code of "template-fewbricks-demo.php" to see how to get Fewbricks to display data.

Hopefully you now have a better understanding of how Fewbricks works. Keep on reading this deocument to the end to understand even more.
 
## Usage

We recommend that you create at least one test field group using ACFs GUI and set it's location settings to "post type is equal to post" _and_ "post type is equal to page". That way the field group will never show up anywhere in the administration system and you can use it as a playground.

### Fields
The field types that are available for creating bricks are exactly the same field types that can be used in ACF. The settings for each field are also the same and have the same name as in ACF. This means that if you want to find out what you can do with a field you can either look in the class for that field, located in [plugins]/fewbricks/lib/acf/fields, or you can create a field in ACFs GUI and then use ACFs export-to-code-functionality to see the available options for a field and how they should be set. If ACF is updated with new field options, it doesn't matter if those options are available in the field classes in [plugins]/fewbricks/lib/acf/fields or not since they will be merged with ACFs original field classes anyways. The only reason for having the array `$base_settings` in each class in [plugins]/fewbricks/lib/acf/fields is to make it easier for developers to find out what settings are available to a field.

The settings that all fields have in common are:

* label - The text displayed to the administrator as label for the input field.

* name - Must be unique on its level. This means that if you create a bunch of field instances in a brick, you can not give two fields in the brick the same name. However, if you for example are re-using bricks in a brick, you don't have to worry that a field in the re-used bricks may have the same name as a field in the "master brick".

* key - **Must be a unique value across the theme.** This value must never be changed once it has been set and the field have been used once since it is what ACF uses to find data in the database. We recommend that you use something like the time and date for this. So for example if you are registering a field at 10.45 on April 6, 2015, you use 1504061045 (or whatever format you like your dates in) as the base and then append a random character to it in case you would go on to create another key the exact same minute. So you might end up with 1504061045q. Unless you register another brick at the same minute and for some reason use the same random letter, you will never risk having two identical values. You can *not* use a dynamic value such as time(). Also note that you *must* add a letter somewhere in the key. If you put Fewbricks in [developer mode](#developer-mode), you will get a warning if you try to set a key that is already in use.   
 
* settings - You can set all other settings that a field have by passing an associative array as the third argument when creating a field instance. The easiest way to find out what settings are available to a field is to check out the corresponding class in [plugins]/lib/acf/fields. You could also use the GUI for ACF to create a field group with an instance of the field type without setting any values on it and then, under Custom Fields -> Tools, generate export code for the field group. In that code, you will find an array with all the available settings.

**Note:** If you add an add-on field, you must create a field class for that field in [theme]/fewbricks/acf/fields/. We have placed an example class in that folder to explain what a field class should hold.

### Creating a brick
Each brick has its own class placed in the folder named "bricks". Each class have a number of fields. Field instances can either be created directly in a brick, but a brick may also reuse existing bricks.
 
 First, make sure that a brick that does exactly what you want to achieve does not already exist. If it doesn't, see if a brick doing almost what you want to achieve exists. If it does, consider extending that brick or at least copy the existing code and use it as a start template for your new brick.
 
 If you need to write a brick from scratch: create a new file in the bricks folder and give it a name that describes what the brick does. Try to keep this short but still logical, for example text-and-list.php would hold the class text_and_list and consist of a field for text and maybe a repeater for list items.
 
 A brick-class must extend `project_brick` and have at least these functions:
  
 * `set_fields()` - this is where you specify the fields that the brick should handle. For example a text field, a wysiwyg field, a repeater with another module and a file upload. Or maybe it's a flexible content with a couple of layouts. 
 
 * `get_brick_html()` - this function should return the HTML for the brick.
 
#### Creating a standard brick
 Let's create a standard brick with a text field and a wysiwyg-area. This is of course not a very impressive example since we are basically adding a brick that does what WordPress does out of the box. But it's a good place to start showing how to create stuff in fewbricks.
 
1. In the folder "[theme]/fewbricks/bricks", create a file named headline-and-content.php.
 
2. Copy the code from the file [_brick-boilerplate.php](fewbricks/bricks/_brick-boilerplate.php) and paste it into your newly created file.
 
3. Now, lets add the fields to the brick. In the set_fields-function, add this code:

    ```php
    $this->add_field(new acf_fields\text('Headline', 'headline', 1509041509a'));
    $this->add_field(new acf_fields\wysiwyg('Content', 'content', '1509041509b'));
    ```
    
    With the code above, we have added two fields. One text-field and one wysiwyg-field. Each field has gotten a label to display to the administrator, a name we can use when getting the data for the field and a site-wide-unique key. It is __very important__ that the keys are unique on a site wide level.
    
4. Let's add our new brick to a field group: in the folder [theme]/fewbricks/field-groups, either create a new PHP-file or edit an existing one. If you create a new one, make sure to require it in [theme]/field-groups/init.php. Add this code to the field groups file:
  
    ```php
    $fg = new fewbricks\acf\field_group('Test content', '1504201020o', $location, 1);
    $fg->add_brick(new fewbricks\bricks\text_and_content('text_and_content_test', '1509041512c');
    $fg->register();
    ```
        
    Here we create a new field group with a label, a site-wide-unique key, a location (more about that in a minute) and an order. The order indicates where the field group should be positioned in relation to other field groups when editing the content of the page. A field group with order 1 is positioned before a field group with order set to 2, 2 before 3 and so on. If you want to set any of the other settings available to a field group, you can pass an associative array with those settings as the fifth argument. To find out what settings are available, check out the code in the constructor of [lib/acf/field-group.php](lib/acf/field-group.php) .
    
    We then add a brick to the field group. The brick gets instantiated with a name (text_and_content_test) that must be unique for all bricks and fields on the top level of all field groups for this page.
    
    We also pass a site-wide-unique key for the brick.
    
    The location is an assocative array that may look something like this:
    
    ```php
    [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ],
      ]
    ]
    ```
        
    Store that array in a variable named `$location` that you add to the field group file that you are working on and make sura that `$location` is set before the code in step 4 above.
        
    Locations can be tricky so use the playground field group that we recommend that you create (see under "Basic idea" for more info on this). Using the example above, the field group will show up on all pages.
    
5. When the location has been set, load something in the backend where the field group should show up (which will be any page if you have used the location example above). You should now see the field group on the page and the original content-wysiwyg should be gone.
    
    Add some content in the headline and content field and load up the page in the frontend. Is your content not being displayed? That's expected since the get_brick__html-function of our new brick is empty. Let's fix that now.
    
6. Now, add the following code where you want the content to show up (again, using the example code above, this would be in the standard page template):

    ```php
    <?php
        echo (new fewbricks\bricks\text_and_content('text_and_content_test'))->get_html();
    ?>
    ```
    
    We are calling `get_html()` and not `get_brick_html()` directly since `get_html()` is a function in the parent bricks class that will set some things up for us. `get_html()` will then call `get_brick_html()` and return whatever you return from that function.
    
    Note that we are using the name (text_and_content_test) that we set when adding the brick to the field group in step 4.
    
    Almost done, we need to check out step 7 first.
    
7. In probably every case you will want the brick to output something. That's where the function `get_brick_html()` in each brick class comes in to play. This function must be present in all brick-classes and should return (not echo) what you want printed.
 
    What you decide to do in `get_brick_html()` is completely up to you, but here are three different ways:
 
    1. Build the HTML directly in the function and return it HTML. In our example, this could look something like the following code which you can simply paste to `get_brick_html()`.

        ```php
        $html = '<h1>' . $this->get_field('headline') . '</h1>';
        $html .= 'The content: ' . $this->get_field('content');
        return $html
        ```
        
    2. Build the HTML in an external file named after the name of the brick class it belongs to. So for our example class `headline_and_content` we would create the file [theme]/fewbricks/bricks/headline-and-content.template.php (note the .template part of the name) and put the following lines in it:
    
        ```php
        <?php
        echo '<h1>' . $this->get_field('headline') . '</h1>
        The content: ' . $this->get_field('content');
        ?>
        ```
        
        The template-file have access to the same data and variables that you have if you are building the HTML right in `get_brick_html()`.
        
        For your convenience, the main brick-class have a function named `get_brick_template_html()` for this. It will look for a template file with the name structure described above, include that file and return the outcome of it. You may also pass an argument to the function telling it where to look for a specific template file. Once again, you can pass the path, the filename is as described above. Check out the [filters-section](#filters) of this README for filters available in this function.
            
        We are using this approach in [theme]/fewbricks/bricks/demo-jumbotron.php.
                
    3. If you are using a templating system, you can use that. We have included an example of how to utilize [Timber](http://upstatement.com/timber/) in an commented out version of `get_brick_html` in [theme]/fewbricks/bricks/demo-video.php.
                
    Including external files like in i and ii will have some minor impact on performance but if you feel that having the HTML in an external file is the way to go, go ahead. 
        
    The `get_field()`-function being used is a wrapper function for ACFs own `get_field()` which takes care of adding any needed prefixes to get the value. Note that we are using the name values that we set when adding fields under step 3 above.
    
    We have also added the function `get_field_values()` to the main brick class. It enables you to pass an array of field names and get an array with the values back in return.
   
#### Is that all Fewbricks can do?
Nope. Like we said, you can create flexible content, repeaters, bricks incorporating other bricks and also create field groups on the fly. For more on how to do this, check the files in the directories "field-groups", "demo", "bricks" and "brick-layouts". Don't miss the brick named "demo-flexible-brick"!

### Important about naming fields
Due to restrictions in the WordPress table structure, the max length of a field name is 64 characters. So if you have fields that go a couple of levels deep (for example a brick in a flexible field that have a repeater), you may run out of space for the name. Therefore, it is wise to shorten names so instead of for example "download_button", use "dl_btn". This should be considered whe creating instances of bricks and fields. If the value of a field is not saved, the reason is most likely that the name is too long.
  
### Brick layouts
Brick layouts are not the same as layouts in ACF.

Often when printing bricks you want to have some wrapping HTML that is the same for each brick. This can for example be Bootstraps "row" and "col"-divs. Other times, you might only want the "core html" of the brick without anything wrapping it. To keep it DRY, we have created a basic layout system.

Brick layout files are stored in the brick-layouts directory and are used by passing the name(s) of the file(s) without the file extension (.php) to the `get_html`-function of a brick. If you dont want to use brick layouts, don't pass anything (or `false`) to the function. Check out the [filters-section] on how to change how layouts are found.

You can also create layouts using Timber. The only thing you have to do different compared to when using a basic PHP-file is to include '.twig' in the filename when passing it to `get_html`.

If a string or array is passed, the file(s) with the name(s) is then included after the core html of a brick has been built. This means that you have access to these variables in a brick layout-file:

* `$html` - the html of the brick
* `$this` - an instance of the current brick class. This can be used to find out for example what background color should be set on the wrapping row using something like `$this->get_data_value('bg')`.

If you want to create data on the fly in a brick that can be used in a layout, use `set_data_item()` / `get_data_item()` in [the master brick class](lib/brick.php). These functions even allows you to group data for keeping a better structure. See [demo_buttons_list](fewbricks/bricks/demo-button-list.php) and [demo-layout-1.php](fewbricks/brick-layouts/demo-layout-1.php) for example on how to utilize this.

### Fewbricks specific settings for fields and bricks
There are some settings that we have added to make using Fewbricks easier.

*For fields and bricks*
`field_label_prefix` - Text to prepend on labels. We will automatically add a space between the prefix and the original label. Note that if you set this on a brick, all the bricks fields, including fields for any sub brick, will get the prefix.
`field_label_suffix` - Same as above but a suffix.

### CSS
There are no restrictions on how you organize your CSS related to fewbricks. One idea is that you create a css/less/sass/what-have-you file for each module and place it alongside the PHP-file in the bricks-fodler and giving it the same name as the PHP-file. So for example the brick "image-and-text.php" would have a style file names "image-and-text.[css|scss|less]". But you caould just as well place the CSS in regular CSS files in your assets directory or any other way you want to.

The brick-class also have a function called `set_inline_css` that you can use to set inline css attributes on the fly in a brick. That CSS can then be used for example in a layout. See [demo_buttons_list](fewbricks/bricks/demo-button-list.php) and [demo-layout-1.php](fewbricks/brick-layouts/demo-layout-1.php) for example on how to utilize this. Don't miss the fact that you can store inline css in groups which can come in handy if youwant to create inline CSS for multiple elements.

### Developer mode
By setting Fewbricks in developer mode, some extra debugging related to Fewbricks and ACF will become available. Also, every time a field group is registered, a check for duplicate keys will be executed. You enable developer mode by setting a constant, preferrably in wp-config.php, named FEWBRICKS_DEV_MODE to true:
`define('FEWBRICKS_DEV_MODE', true);`

If developer mode is enabled, you can also var dump the fields settings each time a field group is registered. This is done by passing a get variable named "dumpfewbricksfields" to any page like so: http://mywordpressinstall.com/wp-admin/?dumpfewbricksfield .

#### Field info
If you use the technique described above to enter developer mode, you will also get info about each field in the form of a yellow and blue info field next to each field in the backend. The yellow field displays the name of the field and the blue one holds the key. If you want the developer mode activated but not displaying the field info (it uses JavaScript which can cause stuff on the admin screen to jump around and load slowly which can be annoying even in developer mode), add the following code to the same file that you activated developer mode in:
 `define('FEWBRICKS_HIDE_ACF_INFO', true);`

The code displaying the field info was originally found in the plugin [ACF: Field Snitch](https://sv.wordpress.org/plugins/advanced-custom-fields-field-snitch/) by [Stupid Studio](https://stupid-studio.com/) and modified by [Bryan Willis](https://gist.github.com/bryanwillis/bbfdce5febd3db16c53c#file-acf-field-snitch-v5-js) to work with verison 5 of ACF. 

### ACF Local JSON
Fewbrikcs does support [ACF Local JSON](http://www.advancedcustomfields.com/resources/local-json/) but tests show that there is hardly any performance differences between standard Fewbricks and Local JSON. This is most likely due to the fact that neither use any DB-queries to get the field groups like standard ACF does.

If you still want to use Local JSON, follow these steps to activate it:

1. As outlined in the [ACF instructions for local JSON](http://www.advancedcustomfields.com/resources/local-json/): in the themes directory, create a directory named acf-json.

2. In the admin area, navigate to the Fewbricks admin page (this page is only visible if Fewbricks is set in developer mode) which is placed in the ACF menu. Click "Build JSON" and let the page reload.

3. In a file that is always included, preferably wp-config.php, define a constant named FEWBRICKS_USE_JSON: `define('FEWBRICKS_USE_ACF_JSON', true);`.

4. That's all there is to it. ACF will now load settings from the JSON-files in the acf-json directory created in step 1. 

#### Important about local JSON 
Every time you edit any fields in a field group or brick, you will need to rebuild the local JSON by taking the action outlined in step 2 above. One suggested workflow is that you always have Local JSON activated in all environments including development. Then when you edit a modules' fields and don't see the changes in the editing area of a page/post/options etc., you will be reminded of that you need to rebuild the JSON. When you are ready to push to production, the JSON will be up to date.

# Available fields
These are the fields that are available in Fewbricks out of the box. If you add an ACF plugin that att it's own field, you need to create a new class in fewbricks/acf/fields based on [fewbricks/acf/fields/fewbricks-example-field.php](fewbricks/acf/fields/fewbricks-example-field.php). Make sure to read the comments in that file.

## Standard ACF fields
The goal is to have all the fields available in ACF also available in Fewbricks. Documentation on these standars ACF fields are available in the [ACF Documentation](https://www.advancedcustomfields.com/resources/).

+ Checkbox
+ Color picker
+ Date picker
+ E-mail
+ File
+ Flexible content
+ Gallery
+ Google map
+ Image
+ Message
+ Number
+ oEmbed
+ Page link
+ Password
+ Post object
+ Radio button
+ Relationship
+ Repeater
+ Select
+ Tab
+ Taxonomy
+ Text
+ Textarea
+ True/false
+ URL
+ User
+ WYSIWYG

## Extra fields
+ Fewbricks hidden - Used for base functionality in Fewbricks. 

## Filters

The following filters are available in Fewbricks:

### `fewbricks/project_files_base_path`
Allows you to change the path of the project Fewbricks folder.

Simple example (namespaces, OOP-plugins etc. are waaaay outside the scope of this readme):
```php
add_filter('fewbricks/project_files_base_path', 'get_project_files_base_path');
function fewbricks_project_files_base_path() {
    // Path to where you placed the fewbricks-directory that originally resided
    // in the main fewbricks directory.
    // Include directory name, exclude trailing slash
    return [PATH];
}
```

### `fewbricks/brick/brick_template_file_extension`
Allows you to change the file extension of template files used in [brick.php -> get_brick_template_html()](lib/brick.php). Your filter should return for example ".view.php" or ".php". Note the dot at the beginning. 

### `fewbricks/brick/brick_template_base_path`
Allows you to change the standard path of brick templates in [lib/brick.php -> get_brick_template_html()](lib/brick.php). If you pass a `$template_base_path` to `get_brick_template_html()` this filter will be ignored. Your filter should return the path without a trailing slash.

### `fewbricks/brick/brick_layout_base_path`
Allows you to change the base path of layout files used in [lib/brick.php -> get_brick_layouted_html()]. Your filter should return return the path without a trailing slash.
