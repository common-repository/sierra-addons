<?php
namespace WPSierraElements;

use WPSierraElements\Widgets\WPSierra_Posts;
use WPSierraElements\Widgets\WPSierra_Button;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		// Add new Elementor Categories
		add_action( 'elementor/init', [ $this, 'add_elementor_category' ] );
		add_action( 'elementor/frontend/after_register_scripts', function() {
		wp_register_script( 'sierra-elementor-widgets', plugins_url( '/assets/js/sierra-widgets.js', SIERRA_ADDONS_URL ), [ 'jquery' ], false, true );

		} );
		// ENQUEUE // Enqueueing Frontend stylesheet and scripts.
		add_action( 'elementor/editor/after_enqueue_scripts', function() {
		    wp_enqueue_style( 'sierra-addons-css', plugin_dir_url( __FILE__ ) . 'assets/css/sierra-widgets.css' );
        wp_enqueue_script( 'sierra-post-carousel-widget' );
    });
		// FRONTEND // After Elementor registers all styles.
		add_action( 'elementor/frontend/after_register_styles', function() {
		    wp_enqueue_style( 'sierra-addons-css', plugin_dir_url( __FILE__ ) . 'assets/css/sierra-widgets.css' , array());
        wp_enqueue_script( 'sierra-post-carousel-widget' );
    });
		// EDITOR // Before the editor scripts enqueuing.
		add_action( 'elementor/editor/before_enqueue_scripts', function() {
		    wp_enqueue_style( 'sierra-addons-css', plugin_dir_url( __FILE__ ) . 'assets/css/sierra-widgets.css' , array());
        wp_enqueue_script( 'sierra-post-carousel-widget' );
    });
	}

	/**
	 * Add new Elementor Categories
	 *
	 * Register new widget categories for Themesty Core widgets.
	 *
	 * @since 1.0.0
	 * @since 1.7.1 The method moved to this class.
	 *
	 * @access public
	 */
	public function add_elementor_category() {
			\Elementor\Plugin::instance()->elements_manager->add_category( 'wp-sierra-widgets', [
					'title' => __( 'WP Sierra Widgets', 'sierra-addons' ),
			], 1 );
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/el-widgets/sierra-posts.php';
		require __DIR__ . '/el-widgets/sierra-button.php';
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \WPSierraElements\Widgets\WPSierra_Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \WPSierraElements\Widgets\WPSierra_Button() );
	}
}

new Plugin();
