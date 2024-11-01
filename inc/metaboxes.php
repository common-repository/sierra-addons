<?php

//Register metaboxes

if ( ! class_exists( 'Sierra_Metaboxes' ) ) {
	/**
	 * Main ButterBean class.  Runs the show.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	final class Sierra_Metaboxes {
		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function setup_actions() {
			// Register managers, sections, settings, and controls.
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
		}
		/**
		 * Registers managers, sections, controls, and settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `ButterBean` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register( $butterbean, $post_type ) {

			// Register our custom manager.
			$butterbean->register_manager(
				'page_manager',
				array(
					'label'     => esc_html__( 'Page Settings', 'sierra-addons' ),
					'post_type' => 'page',
					'context'		=> 'side',
					'priority'	=> 'high',
				)
			);
			// Get our custom manager object.
			$manager = $butterbean->get_manager( 'page_manager' );
			// Register a section.
			$manager->register_section(
				'page_section_header',
				array(
					'label' => esc_html__( 'Settings', 'sierra-addons' ),
					'icon' => 'dashicons-admin-generic',
				)
			);
			// Register a control.
			$manager->register_control(
				'page_transparent_header',
				array(
					'type'    => 'checkbox',
					'section' => 'page_section_header',
					'label'   => esc_html__( 'Transparent Header', 'sierra-addons' ),
				)
			);
			// Register a setting.
			$manager->register_setting(
				'page_transparent_header',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);
			// Register a control.
			$manager->register_control(
				'page_alternative_logo',
				array(
					'type'    => 'checkbox',
					'section' => 'page_section_header',
					'label'   => esc_html__( 'Alternative Logo In Transparent Header', 'sierra-addons' ),
				)
			);
			// Register a setting.
			$manager->register_setting(
				'page_alternative_logo',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			// Register our custom manager.
			$butterbean->register_manager(
				'post_manager',
				array(
					'label'     => esc_html__( 'Post Settings', 'sierra-addons' ),
					'post_type' => 'post',
					'context'		=> 'side',
					'priority'	=> 'high',
				)
			);
			// Get our custom manager object.
			$manager = $butterbean->get_manager( 'post_manager' );
			// Register a section.
			$manager->register_section(
				'post_section_header',
				array(
					'label' => esc_html__( 'Settings', 'sierra-addons' ),
					//'icon' => 'dashicons-admin-generic',
				)
			);
			// Register a control.
			$manager->register_control(
				'featured_post',
				array(
					'type'    => 'checkbox',
					'section' => 'post_section_header',
					'label'   => esc_html__( 'Display Post In Featured Style', 'sierra-addons' ),
				)
			);
			// Register a setting.
			$manager->register_setting(
				'featured_post',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}
			return $instance;
		}
		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function __construct() {}
	}
	Sierra_Metaboxes::get_instance();
}
