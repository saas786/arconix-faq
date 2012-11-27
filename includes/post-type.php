<?php
/**
 * Create FAQ Post Type
 *
 * @since 0.9
 * @version 1.2
 */
function faq_create_post_type() {
    $args = apply_filters( 'arconix_faq_post_type_args', array(
        'labels' => array(
            'name' => __( 'FAQ', 'acf' ),
            'singular_name' => __( 'FAQ', 'acf' ),
            'add_new' => __( 'Add New', 'acf' ),
            'add_new_item' => __( 'Add New Question', 'acf' ),
            'edit' => __( 'Edit', 'acf' ),
            'edit_item' => __( 'Edit Question', 'acf' ),
            'new_item' => __( 'New Question', 'acf' ),
            'view' => __( 'View FAQ', 'acf' ),
            'view_item' => __( 'View Question', 'acf' ),
            'search_items' => __( 'Search FAQ', 'acf' ),
            'not_found' => __( 'No FAQs found', 'acf' ),
            'not_found_in_trash' => __( 'No FAQs found in Trash', 'acf' )
        ),
        'public' => true,
        'query_var' => true,
        'menu_position' => 20,
        'menu_icon' => ACF_IMAGES_URL . 'faq-16x16.png',
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'revisions' ),
        'rewrite' => array( 'slug' => 'faqs', 'with_front' => false )
    ) );
}

    register_post_type( 'faq', $args );