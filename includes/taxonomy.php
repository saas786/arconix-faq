<?php
/**
 * Create the Custom Taxonomy
 *
 * @since 1.1
 */
function faq_create_taxonomy() {

    $args = apply_filters( 'arconix_faq_taxonomy_args', array(
        'labels' => array(
            'name' => __( 'Groups', 'acf' ),
            'singular_name' => __( 'Group', 'acf' ),
            'search_items' => __( 'Search Groups', 'acf' ),
            'popular_items' => __( 'Popular Groups', 'acf' ),
            'all_items' => __( 'All Groups', 'acf' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Group', 'acf' ),
            'update_item' => __( 'Update Group', 'acf' ),
            'add_new_item' => __( 'Add New Group', 'acf' ),
            'new_item_name' => __( 'New Group Name', 'acf' ),
            'separate_items_with_commas' => __( 'Separate groups with commas', 'acf' ),
            'add_or_remove_items' => __( 'Add or remove groups', 'acf' ),
            'choose_from_most_used' => __( 'Choose from the most used groups', 'acf' ),
            'menu_name' => __( 'Groups', 'acf' ),
        ),
        'hierarchical' => false,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'group' )
    ) );
    register_taxonomy( 'group', 'faq', $args );
}

