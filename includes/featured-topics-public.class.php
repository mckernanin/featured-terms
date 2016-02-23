<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 * @package	   Featured_Topics
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Kevin McKernan <kevin@mckernan.in>
 */
class Featured_Topics_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'enqueue_styles' ) );
		add_action( 'init', array( $this, 'enqueue_scripts' ) );
		add_shortcode( 'featured-topics', array( $this, 'shortcode_featured_topics_display' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// wp_register_style( 'featured-topics-css', $fs_careers->installed_url . 'assets/css/fs-careers.css', array( 'chosen-css' ), filemtime( $fs_careers->installed_dir . '/assets/css/fs-careers.css' ), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// wp_register_script( 'featured-topics-js', $fs_careers->installed_url . '/assets/js/fs-careers.js', array( 'jquery', 'chosen-js' ), filemtime( $fs_careers->installed_dir . '/assets/js/fs-careers.js' ), false );
	}

	/**
	 * Register shortcode for current position openings.
	 *
	 * @since    1.0.0
	 * @param array $atts Shortcode attributes.
	 */
	public function shortcode_featured_topics_display( $atts ) {
		ob_start();
		global $Featured_Topics;
		// wp_enqueue_script( 'fs-careers-js' );
		// wp_enqueue_style( 'fs-careers-css' );
		include( $Featured_Topics->installed_dir . '/includes/templates/featured-topics-display.php' );
		$shortcode_output = ob_get_clean();
		return $shortcode_output;
	}
}

global $Featured_Topics_Public;
$Featured_Topics_Public = new Featured_Topics_Public();
