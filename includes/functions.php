<?php
/**
 *  Register the javascript
 * 
 * @since 0.9
 */
function register_script() {
    if( file_exists( get_stylesheet_directory() . "/arconix-faq.js" ) ) {
        wp_register_script( 'arconix-faq-js', get_stylesheet_directory_uri() . '/arconix-faq.js', array( 'jquery' ), ACF_VERSION, true );
    } elseif( file_exists( get_template_directory() . "/arconix-faq.js" ) ) {
        wp_register_script( 'arconix-faq-js', get_template_directory_uri() . '/arconix-faq.js', array( 'jquery' ), ACF_VERSION, true );
    } else {
        wp_register_script( 'arconix-faq-js', ACF_INCLUDES_URL . 'faq.js', array( 'jquery' ), ACF_VERSION, true );
    }
}

/**
 * Load the javascript on a page where the FAQ shortcode is used
 *
 * @since 1.0
 */
function print_script() {
    if( !self::$load_js )
        return;

    wp_print_scripts( 'arconix-faq-js' );
}

/**
 * Load the plugin's stylesheet
 * 
 * @since 0.9
 */
function enqueue_css() {
    if( file_exists( get_stylesheet_directory() . '/arconix-faq.css' ) ) {
        wp_enqueue_style( 'arconix-faq', get_stylesheet_directory_uri() . '/arconix-faq.css', array( ), ACF_VERSION );
    } elseif( file_exists( get_template_directory() . '/arconix-faq.css' ) ) {
        wp_enqueue_style( 'arconix-faq', get_template_directory_uri() . '/arconix-faq.css', array( ), ACF_VERSION );
    } else {
        wp_enqueue_style( 'arconix-faq', ACF_INCLUDES_URL . 'faq.css', array( ), ACF_VERSION );
    }
}

/**
 * Display FAQs
 *
 * @param type $atts
 * @since 0.9
 * @version 1.1.1
 */
function faq_shortcode( $atts ) {
    // Set the js flag
    self::$load_js = true;

    $defaults = apply_filters( 'arconix_faq_shortcode_query_args', array(
        'showposts' => 'all',
        'order' => 'ASC',
        'orderby' => 'title',
        'group' => ''
    ) );

    extract( shortcode_atts( $defaults, $atts ) );

    /** Translate 'all' to -1 for query terms */
    if( $showposts == "all" )
        $showposts = "-1";

    $return = '';

    /** Get the taxonomy terms assigned to all FAQs */
    $terms = get_terms( 'group' );

    /** If there are any terms being used, loop through each one to output the relevant FAQ's, else just output all FAQs */
    if( $terms ) {

        foreach( $terms as $term ) {

            /** If a user sets a specific group in the shortcode params, that's the only one we care about */
            if( $group and $term->slug != $group ) {
                continue;
            }

            /** Build my query showing only faq's from the taxonomy term we're looping through */
            $faq_query = new WP_Query( array(
                'post_type' => 'faq',
                'order' => $order,
                'orderby' => $orderby,
                'posts_per_page' => $showposts,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'group',
                        'field' => 'slug',
                        'terms' => array( $term->slug ),
                        'operator' => 'IN'
                    )
                )
            ) );


            if( $faq_query->have_posts() ) {

                $return .= '<h3 class="arconix-faq-term-title arconix-faq-term-' . $term->slug . '">' . $term->name . '</h3>';

                /** If the term has a description, show it */
                if( $term->description )
                    $return .= '<p class="arconix-faq-term-description">' . $term->description . '</p>';

                /** Loop through the rest of the posts for the term */
                while( $faq_query->have_posts() ) : $faq_query->the_post();

                    $return .= '<div id="post-' . get_the_ID() . '" class="arconix-faq-wrap">';
                    $return .= '<div class="arconix-faq-title">' . get_the_title() . '</div>';
                    $return .= '<div class="arconix-faq-content">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
                    $return .= '</div>';

                endwhile;
            }
            wp_reset_postdata();
        }
    }
    /** If there are no faq groups */
    else {

        $faq_query = new WP_Query( array(
            'post_type' => 'faq',
            'order' => $order,
            'orderby' => $orderby,
            'posts_per_page' => $showposts
        ) );

        if( $faq_query->have_posts() ) {

            /* Shhh! I'm not ready yet
              $return .= '<div class="arconix-faq-button">Expand/Collapse All</div>'; */

            while( $faq_query->have_posts() ) : $faq_query->the_post();

                $return .= '<div id="post-' . get_the_ID() . '" class="arconix-faq-wrap">';
                $return .= '<div class="arconix-faq-title">' . get_the_title() . '</div>';
                $return .= '<div class="arconix-faq-content">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
                $return .= '</div>';

            endwhile;
        }
        wp_reset_postdata();
    }

    return $return;
}
