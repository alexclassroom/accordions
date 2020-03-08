<?php
/*
Plugin Name: Accordions by PickPlugins
Plugin URI: https://www.pickplugins.com/item/accordions-html-css3-responsive-accordion-grid-for-wordpress/?ref=dashboard
Description: Fully responsive and mobile ready accordion grid for wordpress.
Version: 2.1.18
WC requires at least: 3.0.0
WC tested up to: 3.6
Author: PickPlugins
Author URI: http://pickplugins.com
Text Domain: accordions
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class Accordions{
	
	public function __construct(){

		define('accordions_plugin_url', plugins_url('/', __FILE__)  );
		define('accordions_plugin_dir', plugin_dir_path( __FILE__ ) );
        define('accordions_version', '2.1.18' );
        define('accordions_plugin_name', 'Accordions' );
        define('accordions_plugin_basename', plugin_basename( __FILE__ ) );


        require_once( accordions_plugin_dir . 'includes/class-post-types.php');

        require_once( accordions_plugin_dir . 'includes/class-post-meta-accordions.php');
        require_once( accordions_plugin_dir . 'includes/class-post-meta-accordions-hook.php');

        require_once( accordions_plugin_dir . 'includes/class-settings.php');
        require_once( accordions_plugin_dir . 'includes/class-settings-hook.php');

        require_once( accordions_plugin_dir . 'includes/class-post-meta-product.php');
        require_once( accordions_plugin_dir . 'includes/class-admin-notices.php');
        require_once( accordions_plugin_dir . 'includes/functions-data-upgrade.php');



        require_once( accordions_plugin_dir . 'includes/class-settings-tabs.php');
        require_once( accordions_plugin_dir . 'includes/class-accordions-support.php');
		//require_once( accordions_plugin_dir . 'includes/meta-new.php');
		require_once( accordions_plugin_dir . 'includes/functions.php');
		require_once( accordions_plugin_dir . 'includes/functions-wc.php');
		require_once( accordions_plugin_dir . 'includes/class-functions.php');
		require_once( accordions_plugin_dir . 'includes/class-shortcodes.php');
		require_once( accordions_plugin_dir . 'includes/duplicate-post.php');
        //require_once( accordions_plugin_dir . 'includes/class-WPAdminSettings.php');



        require_once( accordions_plugin_dir . 'templates/accordion/accordion-hook.php');


        add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
		
		add_action( 'plugins_loaded', array( $this, 'accordions_load_textdomain' ));
        add_filter('cron_schedules', array($this, 'cron_recurrence_interval'));


        require_once( accordions_plugin_dir . 'includes/class-widget-accordions.php');
				
		add_action( 'widgets_init', array( $this, 'widget_register' ) );
		
		// Display shortcode in widgets
		add_filter('widget_text', 'do_shortcode');
        add_filter( 'plugin_action_links_'.accordions_plugin_basename, array( $this, 'plugin_list_pro_link' ));
	}
	
	public function widget_register() {
		register_widget( 'WidgetAccordions' );
	}
	
	public function accordions_load_textdomain() {

        $locale = apply_filters( 'plugin_locale', get_locale(), 'accordions' );
        load_textdomain('accordions', WP_LANG_DIR .'/accordions/accordions-'. $locale .'.mo' );

        load_plugin_textdomain( 'accordions', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

		}

    function cron_recurrence_interval($schedules){

        $schedules['1minute'] = array(
            'interval' => 120,
            'display' => __('1 Minute', 'accordions')
        );


        return $schedules;
    }
	
	public function _install(){
		
		do_action( 'accordions_action_install' );
		
		}		
		
	public function _uninstall(){
		
		do_action( 'accordions_action_uninstall' );
		}		
		
	public function _deactivation(){
		
		do_action( 'accordions_action_deactivation' );
		}
	
	
	public function _front_scripts(){


        wp_register_style('accordions-tabs', plugins_url( 'assets/global/css/themesTabs.style.css', __FILE__ ));
        wp_register_style('fontawesome-5',  accordions_plugin_url.'assets/global/css/font-awesome-5.css');
        wp_register_style('fontawesome-4',  accordions_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('jquery-ui',  accordions_plugin_url.'assets/frontend/css/jquery-ui.css');
        wp_register_style('accordions-themes',  accordions_plugin_url.'assets/global/css/themes.style.css');




		}

	public function _admin_scripts(){

        wp_enqueue_script('accordions_admin_js', plugins_url( 'assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ),'20181018');
        wp_localize_script( 'accordions_admin_js', 'accordions_ajax', array( 'accordions_ajaxurl' => admin_url( 'admin-ajax.php')));

        wp_register_style('settings-tabs', accordions_plugin_url.'assets/settings-tabs/settings-tabs.css');
        wp_register_script('settings-tabs', accordions_plugin_url.'assets/settings-tabs/settings-tabs.js'  , array( 'jquery' ));

        //wp_register_script('codemirror', accordions_plugin_url.'assets/admin/js/codemirror.js' , array( 'jquery' ));
        wp_register_style('codemirror', accordions_plugin_url.'assets/admin/css/codemirror.css');

        wp_register_style('font-awesome-4', accordions_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('font-awesome-5', accordions_plugin_url.'assets/global/css/font-awesome-5.css');


        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);
        wp_enqueue_script('wp-theme-plugin-editor');


        wp_enqueue_editor();



        wp_enqueue_script('accordions_admin_js', plugins_url( 'assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ),'20181018');
        wp_localize_script( 'accordions_admin_js', 'accordions_ajax', array( 'accordions_ajaxurl' => admin_url( 'admin-ajax.php')));







    }

    public function plugin_list_pro_link( $links ) {

        $active_plugins = get_option('active_plugins');

        if(!in_array( 'accordions-pro/accordions-pro.php', (array) $active_plugins )){
            $links['get_premium'] = '<a target="_blank" class="" style=" font-weight:bold;" href="https://www.pickplugins.com/item/accordions-html-css3-responsive-accordion-grid-for-wordpress/?ref=dashboard">'.__('Buy Premium!', 'accordions').'</a>';


        }



        return $links;

    }


}

new Accordions();
