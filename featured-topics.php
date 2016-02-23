<?php
# TODO: Fill out details of this files header comment block
/**
 * Plugin Name: Featured Topics
 * Plugin URI: https://github.com/mckernanin/featured-topics
 * Description:
 * Author:
 * Version: 0.1.1
 * Author URI: https://github.com/mckernanin
 * License: GPL V2
 * Text Domain: featured-topics
 *
 * GitHub Plugin URI: https://github.com/mckernanin/featured-topics
 * GitHub Branch: master
 *
 * @package my_wp_plugin
 * @category plugin
 * @author
 * @internal Plugin derived from https://github.com/scarstens/worpress-plugin-boilerplate-redux
 */

//avoid direct calls to this file, because now WP core and framework has been used
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'Featured_Topics' ) ) {
	class Featured_Topics {

		public $debug;
		public $installed_dir;
		public $installed_url;
		public $admin;
		public $modules;
		public $network;
		public $current_blog_globals;
		public $detect;

		/**
		 * Construct the plugin object
		 *
		 * @since   0.1
		 */
		public function __construct() {

			// hook can be used by mu plugins to modify plugin behavior after plugin is setup
			do_action( get_called_class() . '_preface', $this );

			//simplify getting site options with custom prefix with multisite compatibility
			if ( ! function_exists( 'get_custom_option' ) ) {
				// builds  the function in global scope
				function get_custom_option( $s = '', $network_option = false ) {
					if ( $network_option ) {
						return get_site_option( SITEOPTION_PREFIX . $s );
					} else {
						return get_option( SITEOPTION_PREFIX . $s );
					}
				}
			}

			// Always load libraries first
			$this->load_libary();

			// configure and setup the plugin class variables
			$this->configure_defaults();

			// Load /includes/ folder php files
			$this->load_classes();

			// initialize
			add_action( 'init', array( $this, 'init' ) );

			// hook can be used by mu plugins to modify plugin behavior after plugin is setup
			do_action( get_called_class() . '_setup', $this );

		} // END public function __construct

		/**
		 * Initialize the plugin - for public (front end)
		 *
		 * @since   0.1
		 * @return  void
		 */
		public function init() {

			do_action( get_called_class() . '_before_init' );
			do_action( get_called_class() . '_after_init' );
		}

		/**
		 * Activate the plugin
		 *
		 * @since   0.1
		 * @return  void
		 */
		public static function activate() {

			/*
			 * Create any site options defaults for the plugins, handle deprecated values on upgrades, etc
			 */

		} // END public static function activate

		/**
		 * Deactivate the plugin
		 *
		 * @since   0.1
		 * @return  void
		 */
		public static function deactivate() {

			/*
			 * Do not delete site options on deactivate. Usually only things in here will be related to
			 * cache clearing like updating permalinks since some may no longer exist
			 */

		} // END public static function deactivate

		/**
		 * Loads PHP files in the includes folder
		 *
		 * @since   0.1
		 * @return  void
		 */
		protected function load_classes() {
			// load all files with the pattern *.class.php from the includes directory
			foreach ( glob( dirname( __FILE__ ) . '/includes/*.class.php' ) as $class ) {
				require_once $class;
				$this->modules->count ++;
			}
		}

		/**
		 * Load all files from /lib/ that match extensions like filename.class.php
		 *
		 * @since   0.1
		 * @return  void
		 */
		protected function load_libary() {
			// load all files with the pattern *.php from the directory inc
			foreach ( glob( dirname( __FILE__ ) . '/lib/*.class.php' ) as $class ) {
				require_once $class;
			}
		}

		protected function configure_defaults() {
			// Setup plugins global params
			// TODO: customize with your plugins custom prefix (usually matches your text domain)
			define( 'SITEOPTION_PREFIX', 'my_plugin_option_' );
			$this->modules        = new stdClass();
			$this->modules->count = 0;
			$this->installed_dir  = dirname( __FILE__ );
			$this->installed_url  = plugins_url( '/', __FILE__ );
		}

		/**
		 * This function is used to make it quick and easy to programatically do things only on your development
		 * domains. Typical usage would be to change debugging options or configure sandbox connections to APIs.
		 */
		public static function is_dev() {
			// catches dev.mydomain.com, mydomain.dev, wpengine staging domains and mydomain.staging
			return (bool) ( stristr( WP_NETWORKURL, '.dev' ) || stristr( WP_NETWORKURL, '.wpengine' ) || stristr( WP_NETWORKURL, 'dev.' ) || stristr( WP_NETWORKURL, '.staging' ) );
		}

		/**
		 * Function remove_action_by_class
		 * Used to remove notices and nags or other class actions added with class instances (unable to remove with remove_action)
		 * This is a utility function useful for any plugin/theme that needs to remove hooks created by non-singleton classes
		 *
		 * @param     $hook_name
		 * @param     $class_and_function_list
		 * @param int $priority
		 */
		function remove_action_by_class( $hook_name, $class_and_function_list, $priority = 10 ) {
			global $wp_filter;
			// go through manually created class and function list
			foreach ( $class_and_function_list as $class_search => $function_search ) {
				//limit removals to matching action names (wildcard string matching)
				foreach ( $wp_filter[ $hook_name ][ $priority ] as $instance => $action ) {
					//limit removals again to matching class and function names (wildcard string matching)
					if ( stristr( $instance, $function_search ) && stristr( get_class( $action['function'][0] ), $class_search ) ) {
						//action found, removing action from filters
						unset( $wp_filter[ $hook_name ][10][ $instance ] );
					}
				}
			}
		} // end remove_action_by_class

	} // END class
} // END if(!class_exists())

/**
 * Build and initialize the plugin
 */
if ( class_exists( 'Featured_Topics' ) ) {
	// Installation and un-installation hooks
	register_activation_hook( __FILE__, array( 'Featured_Topics', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'Featured_Topics', 'deactivate' ) );

	// instantiate the plugin class, which should never be instantiated more then once
	global $Featured_Topics;
	$Featured_Topics = new Featured_Topics();
}
