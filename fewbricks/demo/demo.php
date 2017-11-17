<?php

namespace Fewbricks\Demo;

/**
 * Created using https://generatewp.com/post-type/
 */
if (!function_exists('register_fewbricks_custom_post_type')) {

// Register Custom Post Type
    function register_fewbricks_custom_post_type()
    {

        $labels = [
            'name'                  => _x('Fewbricks Demo Post',
                'Post Type General Name', 'fewbricks'),
            'singular_name'         => _x('Fewbricks Demo Posts',
                'Post Type Singular Name', 'fewbricks'),
            'menu_name'             => __('Fewbricks Demo Posts', 'fewbricks'),
            'name_admin_bar'        => __('Fewbricks Demo Post', 'fewbricks'),
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
        ];
        $args   = [
            'label'               => __('Fewbricks Demo Posts', 'fewbricks'),
            'description'         => __('A post type for demoing Fewbricks',
                'fewbricks'),
            'labels'              => $labels,
            'supports'            => ['title', 'custom-fields',],
            'taxonomies'          => ['category', 'post_tag'],
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 2,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'show_in_rest'        => false,
        ];
        register_post_type('fewbricks_demo_post', $args);

    }

    add_action('init', __NAMESPACE__ . '\\register_fewbricks_custom_post_type', 0);

}
