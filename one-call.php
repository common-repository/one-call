<?php
/*
Plugin Name: One Call - WP REST API Extension
Description: Get featured images, categories, tags, taxonomies,custom fields & author details etc all together by one call from WordPress rest api to reduce responsed time. 
Version: 1.1.1
Author: AmaderCode Lab
Author URI: http://www.amadercode.com
Text Domain: one-call
*/

if (!defined('ABSPATH')) {
    exit;
}

define('AC_OCAPI_VERSION', '1.1.1');
define('AC_OCAPI_DIR', dirname(__FILE__));
define('AC_OCAPI_URL', plugins_url('', __FILE__));


if (!class_exists('AC_OCAPI_Mother')) :

    /**
     * Main plugin class
     *
     * @class AC_OCAPI_Mother
     */
    final class AC_OCAPI_Mother{
        private $menu_slug = 'ac-ocapi-settings';
        /**
         * @var AC_OCAPI_Mother The single instance of the class
         */
        protected static $_instance = null;

        /**
         * Main AC_OCAPI_Mother Instance
         *
         * Ensures only one instance of AC_OCAPI_Mother is loaded or can be loaded.
         *
         * @static
         * @return AC_OCAPI_Mother - Main instance
         */
        public static function instance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Constructor
         */
        public function __construct(){

            add_action('admin_menu', array($this, 'ac_ocapi_admin_menu'));
			$this->ac_ocapi_includes();
            add_action('rest_api_init', array($this, 'ac_ocapi_load_responses'));
            if ( is_admin() ) {
                register_activation_hook(__FILE__, array($this, 'ac_ocapi_defualt_options'));
                add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'ac_ocapi_settings_link'));
            }
            add_filter( 'rest_url_prefix', array( __CLASS__, 'ac_ocapi_rest_api_prefix' ), 100 );
        }
		/**
         * Include required core files used in admin and response parts.
         */
        public function ac_ocapi_includes() {
            if ( is_admin() ) {
                include_once('ocapi-includes/class-ocapi-admin.php');
            }
            include_once('ocapi-includes/class-ocapi-responses.php');
        }
		
        /**
         * Add OCAPI plugin under Woocommerce plugin in the admin menu area..
         */
        public function ac_ocapi_admin_menu() {
                $ac_ocapi_admin=new AC_OCAPI_admin();
				add_options_page(
					__( 'One Call API Settings', 'one-call' ),
					__( 'One Call API Settings', 'one-call' ),
					'manage_options',
					$this->menu_slug,
					array(
						&$ac_ocapi_admin,
						'ac_ocapi_admin_page'
					)
				);
        }
        /**
         * Showing settings
         */
       public function ac_ocapi_settings_link($links){
            $mylinks = array(
        '<a href="' . admin_url( 'options-general.php?page='.$this->menu_slug ) . '">One Call API Settings</a>',
        );
        return array_merge( $links, $mylinks );
       }
        /***
         * Set the REST API prifix w
         * defualt: wp-json
         */
        static function ac_ocapi_rest_api_prefix($prefix){
            $ac_ocapi_options = get_option('ac_ocapi_options');
            $ac_ocapi_prefix = $ac_ocapi_options['prefix']!="" ? $ac_ocapi_options['prefix'] : 'wp-json';
            return $ac_ocapi_prefix;
        }

        /**
         * Load the one call responses class.
         */
        public function ac_ocapi_load_responses(){
            $ac_ocapi_responses=new AC_OCAPI_Responses();
        }
        /*
        * Initial Options will be insert as defualt data
        */
        public function ac_ocapi_defualt_options(){
            $ac_ocapi_options = array();
            $ac_ocapi_options['prefix']=sanitize_text_field('');
            $ac_ocapi_options['featured']=filter_var('');
            $ac_ocapi_options['cats']=filter_var('');
            $ac_ocapi_options['tags']=filter_var('');
            $ac_ocapi_options['taxo']=filter_var('ac_ocapi_taxo');
            $ac_ocapi_options['comments']=filter_var('ac_ocapi_comments');
            $ac_ocapi_options['author']=filter_var('ac_ocapi_author');
            add_option('ac_ocapi_options', $ac_ocapi_options);
            $ac_ocapi_wp_defualt_filds=array('id','title','excerpt');
            add_option('ac_ocapi_wp_defualt_filds', $ac_ocapi_wp_defualt_filds);
        }

    }

endif;

/*
 * OCAPI plugin Initialization
 */
 AC_OCAPI_Mother::instance();