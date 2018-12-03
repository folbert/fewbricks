<?php

namespace FewbricksDemo;

/**
 * Here we a
 */
if (!function_exists('registerFewbricksCustomPostTypes')) {

    /**
     * Register a custom post type for Fewbricks demo purposes.
     * Created using https://generatewp.com/post-type/
     */
    function registerFewbricksCustomPostTypes()
    {

        // Allowed max length of 20 forces us to shorten page to "pg" :/
        register_post_type('fewbricks_demo_pg', [
            'label' => __('Fewbricks Demo Posts', 'fewbricks'),
            'description' => __('A post type for demoing Fewbricks', 'fewbricks'),
            'labels' => [
                'name' => _x('Fewbricks Demo Page', 'Post Type General Name', 'fewbricks'),
                'singular_name' => _x('Fewbricks Demo Pages', 'Post Type Singular Name', 'fewbricks'),
                'menu_name' => __('Fewbricks Demo Pages', 'fewbricks'),
                'name_admin_bar' => __('Fewbricks Demo Page', 'fewbricks'),
                'archives' => __('Item Archives', 'fewbricks'),
                'attributes' => __('Item Attributes', 'fewbricks'),
                'parent_item_colon' => __('Parent Item:', 'fewbricks'),
                'all_items' => __('All Items', 'fewbricks'),
                'add_new_item' => __('Add New Item', 'fewbricks'),
                'add_new' => __('Add New', 'fewbricks'),
                'new_item' => __('New Item', 'fewbricks'),
                'edit_item' => __('Edit Item', 'fewbricks'),
                'update_item' => __('Update Item', 'fewbricks'),
                'view_item' => __('View Item', 'fewbricks'),
                'view_items' => __('View Items', 'fewbricks'),
                'search_items' => __('Search Item', 'fewbricks'),
                'not_found' => __('Not found', 'fewbricks'),
                'not_found_in_trash' => __('Not found in Trash', 'fewbricks'),
                'featured_image' => __('Featured Image', 'fewbricks'),
                'set_featured_image' => __('Set featured image', 'fewbricks'),
                'remove_featured_image' => __('Remove featured image', 'fewbricks'),
                'use_featured_image' => __('Use as featured image', 'fewbricks'),
                'insert_into_item' => __('Insert into item', 'fewbricks'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'fewbricks'),
                'items_list' => __('Items list', 'fewbricks'),
                'items_list_navigation' => __('Items list navigation', 'fewbricks'),
                'filter_items_list' => __('Filter items list', 'fewbricks'),
            ],
            // Support some stuff to test hiding it for field groups
            'supports' => ['title', 'custom-fields', 'editor', 'thumbnail'],
            'taxonomies' => ['category', 'post_tag',],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 59.1,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_rest' => false,
            'rewrite' => [
                'slug' => __('fewbricks-demo-page', 'fewbricks'),
            ],
        ]);

        // Lets add another post type so we can test locations
        // Allowed max length of 20 forces us to shorten page to "pg" :/
        register_post_type('fewbricks_demo_pg2', [
            'label' => __('Fewbricks Demo Posts Type 2', 'fewbricks'),
            'description' => __('Another post type for demoing Fewbricks', 'fewbricks'),
            'labels' => [
                'name' => _x('Fewbricks Demo Page Type 2', 'Post Type General Name', 'fewbricks'),
                'singular_name' => _x('Fewbricks Demo Pages Type 2', 'Post Type Singular Name', 'fewbricks'),
                'menu_name' => __('Fewbricks Demo Pages Type 2', 'fewbricks'),
                'name_admin_bar' => __('Fewbricks Demo Page Type 2', 'fewbricks'),
                'archives' => __('Item Archives', 'fewbricks'),
                'attributes' => __('Item Attributes', 'fewbricks'),
                'parent_item_colon' => __('Parent Item:', 'fewbricks'),
                'all_items' => __('All Items', 'fewbricks'),
                'add_new_item' => __('Add New Item', 'fewbricks'),
                'add_new' => __('Add New', 'fewbricks'),
                'new_item' => __('New Item', 'fewbricks'),
                'edit_item' => __('Edit Item', 'fewbricks'),
                'update_item' => __('Update Item', 'fewbricks'),
                'view_item' => __('View Item', 'fewbricks'),
                'view_items' => __('View Items', 'fewbricks'),
                'search_items' => __('Search Item', 'fewbricks'),
                'not_found' => __('Not found', 'fewbricks'),
                'not_found_in_trash' => __('Not found in Trash', 'fewbricks'),
                'featured_image' => __('Featured Image', 'fewbricks'),
                'set_featured_image' => __('Set featured image', 'fewbricks'),
                'remove_featured_image' => __('Remove featured image', 'fewbricks'),
                'use_featured_image' => __('Use as featured image', 'fewbricks'),
                'insert_into_item' => __('Insert into item', 'fewbricks'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'fewbricks'),
                'items_list' => __('Items list', 'fewbricks'),
                'items_list_navigation' => __('Items list navigation', 'fewbricks'),
                'filter_items_list' => __('Filter items list', 'fewbricks'),
            ],
            // Support some stuff to test hiding it for field groups
            'supports' => ['title', 'custom-fields', 'editor', 'thumbnail'],
            'taxonomies' => ['category', 'post_tag',],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 59.2,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_rest' => false,
            'rewrite' => [
                'slug' => __('fewbricks-demo-page-type-2', 'fewbricks'),
            ],
        ]);

    }

    add_action('init', __NAMESPACE__ . '\\registerFewbricksCustomPostTypes', 0);

    /**
     * Add some options pages for us to add field groups to later on
     */
    acf_add_options_page([
        'page_title' => 'Fewbricks Demo Options',
        'menu_slug' => 'fewbricks-demo-options',
    ]);

    acf_add_options_sub_page([
        'page_title' => 'Global texts and data',
        'menu_slug' => 'fewbricks-demo-options--global-texts',
        'parent_slug' => 'fewbricks-demo-options',
    ]);

    acf_add_options_sub_page([
        'page_title' => 'Developer settings',
        'pmenu_slug' => 'fewbricks-demo-options--developer-settings',
        'parent_slug' => 'fewbricks-demo-options',
    ]);

    // Force demo post types to use our template
    add_filter('template_include', function ($template) {

        $post_type = get_post_type();

        if ($post_type === 'fewbricks_demo_pg' or $post_type === 'fewbricks_demo_pg2') {
            $template = __DIR__ . '/views/page-templates/demo-page-template.php';
        }

        return $template;

    }, 99);

}
