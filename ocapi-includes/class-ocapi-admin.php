<?php
/*
*    Admin works will be here.
*/

if (!class_exists('AC_OCAPI_admin')) :
    class AC_OCAPI_admin{
        /**
         * Constructor
         */
        public function __construct(){
            add_action('admin_init', array($this, 'save_settings_options'));
        }
        public function ac_ocapi_admin_page() {
            include_once('ocapi-admin-page.php');
        }
        public function save_settings_options(){
            if (!isset($_POST['ac_ocapi_submit']))
                return false;

            check_admin_referer('nonce_ac_ocapi');

            $ac_ocapi_options = array();
            $ac_ocapi_options['prefix']=sanitize_text_field(isset($_POST['ac_ocapi_api_prefix']) ? $_POST['ac_ocapi_api_prefix'] : '');
            $ac_ocapi_options['featured']=filter_var(isset($_POST['ac_ocapi_featured_media']) ? $_POST['ac_ocapi_featured_media'] : '', FILTER_SANITIZE_STRING);
            $ac_ocapi_options['cats']=filter_var(isset($_POST['ac_ocapi_cats']) ? $_POST['ac_ocapi_cats'] : '', FILTER_SANITIZE_STRING);
            $ac_ocapi_options['tags']=filter_var(isset($_POST['ac_ocapi_tags']) ? $_POST['ac_ocapi_tags'] : '', FILTER_SANITIZE_STRING);
            $ac_ocapi_options['taxo']=filter_var(isset($_POST['ac_ocapi_taxo']) ? $_POST['ac_ocapi_taxo'] : '', FILTER_SANITIZE_STRING);
            $ac_ocapi_options['comments']=filter_var(isset($_POST['ac_ocapi_comments']) ? $_POST['ac_ocapi_comments'] : '', FILTER_SANITIZE_STRING);
            $ac_ocapi_options['author']=filter_var(isset($_POST['ac_ocapi_author']) ? $_POST['ac_ocapi_author'] : '', FILTER_SANITIZE_STRING);
            update_option('ac_ocapi_options', $ac_ocapi_options);
            $ac_ocapi_wp_defualt_filds=$_POST['ac_ocapi_wp_defualt_filds'];
            update_option('ac_ocapi_wp_defualt_filds', $ac_ocapi_wp_defualt_filds);
			//Handling Permalink flush
			flush_rewrite_rules();
            wp_redirect('admin.php?page=ac-ocapi-settings&msg=update');
        }

        
    }
endif;
