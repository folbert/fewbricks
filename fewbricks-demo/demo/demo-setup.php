<?php

/**
 * Code related to setting up the Fewbricks demo
 */

namespace App\FewbricksDemo;

/**
 * Autoloader specific for Fewbricks in your project.
 * The idea to support subfolders comes from
 * https://github.com/macherjek1/mj-fewbricks/commit/913be9ea17
 * This function is defined here and not in the Fewbricks core files for you to be able to
 * edit it to match it to your preferred way of naming classes and for you to be able to
 * change the location of files and namespaces. Or remove it completely and require files as you see fit
 * or use Composer or...
 * Feel free to modify or delete the function as you see fit.
 * The function assumes that you are using the namespace App\FewbricksDemo.
 */
spl_autoload_register(function ($class) {

    //$fileFound = false;

    $namespaceParts = explode('\\', $class);

    // Make sure that we are dealing with something in our own namespace
    if (count($namespaceParts) > 2
        && $namespaceParts[0] === 'App'
        && $namespaceParts[1] === 'FewbricksDemo'
    ) {

        $fileName = end($namespaceParts) . '.php';

        // Start with our base path. Using the helper function will take into account
        // any filters used to modify the base path.
        $path = \Fewbricks\Helpers::getProjectFilesBasePath() . '/lib/';

        // If there is more than App\Fewbricks\Bricks\BrickName.php...
        if (count($namespaceParts) > 3) {

            // ..use the namespaces but remove App/FewbricksDemo and also the last part (the filename) since we will
            // append that later.
            $path .= implode('/', array_slice($namespaceParts, 2, -1)) . '/';

        }

        $path .= $fileName;

        // In a real environment i would probably go without this check to speed things up a bit
        // but since this is a test/dev environment...
        if(file_exists($path)) {
            include $path;
        } else {
            die($path);
            wp_die('Fewbricks could not locate the class ' . $class);
        }

    }

});

/**
 *
 */
if (!function_exists('register_fewbricks_custom_post_type')) {

    /**
     * Register a custom post type for Fewbricks demo purposes.
     * Created using https://generatewp.com/post-type/
     */
    function registerFewbricksCustomPostTypes()
    {

        // Allowed max length of 20 forces us to shorten page to "pg" :/
        register_post_type('fewbricks_demo_pg', [
            'label'               => __('Fewbricks Demo Posts', 'fewbricks'),
            'description'         => __('A post type for demoing Fewbricks',
                'fewbricks'),
            'labels'              => [
                'name'                  => _x('Fewbricks Demo Page',
                    'Post Type General Name', 'fewbricks'),
                'singular_name'         => _x('Fewbricks Demo Pages',
                    'Post Type Singular Name', 'fewbricks'),
                'menu_name'             => __('Fewbricks Demo Pages', 'fewbricks'),
                'name_admin_bar'        => __('Fewbricks Demo Page', 'fewbricks'),
                'archives'              => __('Item Archives', 'fewbricks'),
                'attributes'            => __('Item Attributes', 'fewbricks'),
                'parent_item_colon'     => __('Parent Item:', 'fewbricks'),
                'all_items'             => __('All Items', 'fewbricks'),
                'add_new_item'          => __('Add New Item', 'fewbricks'),
                'add_new'               => __('Add New', 'fewbricks'),
                'new_item'              => __('New Item', 'fewbricks'),
                'edit_item'             => __('Edit Item', 'fewbricks'),
                'update_item'           => __('Update Item', 'fewbricks'),
                'view_item'             => __('View Item', 'fewbricks'),
                'view_items'            => __('View Items', 'fewbricks'),
                'search_items'          => __('Search Item', 'fewbricks'),
                'not_found'             => __('Not found', 'fewbricks'),
                'not_found_in_trash'    => __('Not found in Trash', 'fewbricks'),
                'featured_image'        => __('Featured Image', 'fewbricks'),
                'set_featured_image'    => __('Set featured image', 'fewbricks'),
                'remove_featured_image' => __('Remove featured image', 'fewbricks'),
                'use_featured_image'    => __('Use as featured image', 'fewbricks'),
                'insert_into_item'      => __('Insert into item', 'fewbricks'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'fewbricks'),
                'items_list'            => __('Items list', 'fewbricks'),
                'items_list_navigation' => __('Items list navigation', 'fewbricks'),
                'filter_items_list'     => __('Filter items list', 'fewbricks'),
            ],
            // Support some stuff to test hiding it for field groups
            'supports'            => ['title', 'custom-fields', 'editor', 'thumbnail'],
            'taxonomies'          => ['category', 'post_tag',],
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 59.1,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'show_in_rest'        => false,
            'rewrite'             => [
                'slug' => __('fewbricks-demo-page', 'fewbricks'),
            ],
        ]);

        // Lets add another post type so we can test locations
        // Allowed max length of 20 forces us to shorten page to "pg" :/
        register_post_type('fewbricks_demo_pg2', [
            'label'               => __('Fewbricks Demo Posts Type 2', 'fewbricks'),
            'description'         => __('Another post type for demoing Fewbricks',
                'fewbricks'),
            'labels'              => [
                'name'                  => _x('Fewbricks Demo Page Type 2',
                    'Post Type General Name', 'fewbricks'),
                'singular_name'         => _x('Fewbricks Demo Pages Type 2',
                    'Post Type Singular Name', 'fewbricks'),
                'menu_name'             => __('Fewbricks Demo Pages Type 2', 'fewbricks'),
                'name_admin_bar'        => __('Fewbricks Demo Page Type 2', 'fewbricks'),
                'archives'              => __('Item Archives', 'fewbricks'),
                'attributes'            => __('Item Attributes', 'fewbricks'),
                'parent_item_colon'     => __('Parent Item:', 'fewbricks'),
                'all_items'             => __('All Items', 'fewbricks'),
                'add_new_item'          => __('Add New Item', 'fewbricks'),
                'add_new'               => __('Add New', 'fewbricks'),
                'new_item'              => __('New Item', 'fewbricks'),
                'edit_item'             => __('Edit Item', 'fewbricks'),
                'update_item'           => __('Update Item', 'fewbricks'),
                'view_item'             => __('View Item', 'fewbricks'),
                'view_items'            => __('View Items', 'fewbricks'),
                'search_items'          => __('Search Item', 'fewbricks'),
                'not_found'             => __('Not found', 'fewbricks'),
                'not_found_in_trash'    => __('Not found in Trash', 'fewbricks'),
                'featured_image'        => __('Featured Image', 'fewbricks'),
                'set_featured_image'    => __('Set featured image', 'fewbricks'),
                'remove_featured_image' => __('Remove featured image', 'fewbricks'),
                'use_featured_image'    => __('Use as featured image', 'fewbricks'),
                'insert_into_item'      => __('Insert into item', 'fewbricks'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'fewbricks'),
                'items_list'            => __('Items list', 'fewbricks'),
                'items_list_navigation' => __('Items list navigation', 'fewbricks'),
                'filter_items_list'     => __('Filter items list', 'fewbricks'),
            ],
            // Support some stuff to test hiding it for field groups
            'supports'            => ['title', 'custom-fields', 'editor', 'thumbnail'],
            'taxonomies'          => ['category', 'post_tag',],
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 59.2,
            000001,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'show_in_rest'        => false,
            'rewrite'             => [
                'slug' => __('fewbricks-demo-page-type-2', 'fewbricks'),
            ],
        ]);

    }

    add_action('init', __NAMESPACE__ . '\\registerFewbricksCustomPostTypes',
        0);

}

// Force demo pages to use our demo template
function templateInclude($template)
{

    if (get_post_type() === 'fewbricks_demo_page') {

        $template = __DIR__ . '/demo-page-template.php';
    }

    return $template;
}

// Demo function
add_filter('template_include', __NAMESPACE__ . '\\templateInclude', 99);
