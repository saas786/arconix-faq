<?php
/**
 * Plugin Name: Arconix FAQ
 * Plugin URI: http://arconixpc.com/plugins/arconix-faq
 * Description: Plugin to handle the display of FAQs
 *
 * Version: 1.2
 *
 * Author: John Gardner
 * Author URI: http://arconixpc.com/
 *
 * License: GNU General Public License v2.0
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

class Arconix_FAQ {
    
    /**
     * This var is used in the shortcode to flag the loading of javascript
     * 
     * @var type boolean
     * @since 1.0
     */
    var $load_js;
    
    /**
     * Constructor
     * 
     * @since 1.0
     * @version 1.2
     */
    function __construct() {        
        /* Set the necessary constants */
        $this->constants();
        
        /* Run the necessary functions and add them to their respective hooks */
        $this->hooks();

        /* Register activation hook */
        register_activation_hook( __FILE__, array( $this, 'activation' ) );
        
        /* Register deactivation hook */
        register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );        
    }
    
    /**
     * Defines constants used by the plugin.
     *
     * @since 1.2
     */
    function constants() {
        define( 'ACF_VERSION', '1.2' );
        define( 'ACF_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
        define( 'ACF_INCLUDES_URL', trailingslashit( ACF_URL . 'includes' ) );
        define( 'ACF_IMAGES_URL', trailingslashit( ACF_URL . 'images' ) );
        define( 'ACF_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'ACF_INCLUDES_DIR', trailingslashit( ACF_DIR . 'includes' ) );
    }
    
    /**
     * Run the necessary functions and add them to their respective hooks
     * 
     * @since 1.2
     */
    function hooks() {        
        /* Create the Post Type and Taxoniomy */
        add_action( 'init', 'create_post_type', 11 );
        add_action( 'init', 'create_taxonomy', 11 );
        
        /* Post type updated messages */
        add_filter( 'post_updated_messages', 'updated_messages' );

        /* Modify the Post Type Admin screen */
        add_action( 'admin_head', 'post_type_admin_image' );
        add_filter( 'manage_edit-faq_columns', 'columns_filter' );
        add_action( 'manage_posts_custom_column', 'column_data' );

        /* Register and add the javascript and CSS */
	add_action( 'init', 'register_script' );
	add_action( 'wp_footer', 'print_script' );
	add_action( 'wp_enqueue_scripts', 'enqueue_css' );

        /* Create the shortcode */
        add_shortcode( 'faq', 'faq_shortcode' );

        /* Modify Dashboard widgets */
        add_action( 'right_now_content_table_end', 'right_now' );
	add_action( 'wp_dashboard_setup', 'register_dashboard_widget' );
        
        /* Pull in required files */
        require_once( ACF_INCLUDES_DIR . 'functions.php' );
        require_once( ACF_INCLUDES_DIR . 'post-type.php' );
        
        if( is_admin() )
            require_once( ACF_INCLUDES_DIR . 'admin.php' );
    }
    
    /**
     * Runs on plugin activation
     * 
     * @since 1.2
     */
    function activation() {
        flush_rewrite_rules();
    }

    /**
     * Runs on plugin deactivation
     * 
     * @since 1.2
     */
    function deactivation() {
        flush_rewrite_rules();
    }
    
}

new Arconix_FAQ;