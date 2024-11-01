<?php

//DEMO IMPORT


function sierra_import_files() {
	return array(
		array(
			'import_file_name'             => 'Agency',
			'categories'                   => array( 'Agency', 'Free' ),
			'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'agency/content.xml',
			'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'agency/widgets.wie',
			'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'agency/customizer.dat',
			'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'agency/screenshot.jpg',
			//'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', '' ),
			'preview_url'                  => 'https://wpsierra.com/agency/',
		),

		array(
			'import_file_name'             => 'FlatApp',
			'categories'                   => array( 'App', 'Free' ),
			'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'flatapp/content.xml',
			'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'flatapp/widgets.wie',
			'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'flatapp/customizer.dat',
			'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'flatapp/screenshot.jpg',
			//'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', '' ),
			'preview_url'                  => 'https://wpsierra.com/flatapp/',
		),

		array(
			'import_file_name'             => 'Architect',
			'categories'                   => array( 'Architect', 'Free' ),
			'local_import_file'            => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'architect/content.xml',
			'local_import_widget_file'     => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'architect/widgets.wie',
			'local_import_customizer_file' => trailingslashit( plugin_dir_path( __FILE__ ) ) . 'architect/customizer.dat',
			'import_preview_image_url'     => plugin_dir_url( __FILE__ ) . 'architect/screenshot.jpg',
			//'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', '' ),
			'preview_url'                  => 'https://wpsierra.com/architect/',
		),

	);
}
add_filter( 'pt-ocdi/import_files', 'sierra_import_files' );


// After Import Action



if ( ! function_exists( 'sierra_after_import_setup' ) ) {
	function sierra_after_import_setup( $selected_import ) {

		$front_page_id = get_page_by_title( 'Homepage' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		// Main navigation

		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
		$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );


		// Set main menu

		set_theme_mod( 'nav_menu_locations',
			array(
				'header-menu' => $main_menu->term_id,
				'footer-menu' => $footer_menu->term_id,
			)
		);

		// Assign Front Page

		if ( is_object( $front_page_id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page_id->ID );
		}

		// Assign Posts Page

		if ( is_object( $blog_page_id ) ) {
			update_option( 'page_for_posts', $blog_page_id->ID );
		}

		// Remove Hello World post

		wp_trash_post( 1 );

	}
	add_action( 'pt-ocdi/after_import', 'sierra_after_import_setup' );
}

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

// Do not regenerate thumbnails

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// Demo Importer Popup

if ( ! function_exists( 'sierra_demo_dialog_options' ) ) {
	function sierra_demo_dialog_options( $options ) {
		return array_merge( $options, array(
			'width'       => 430,
			'dialogClass' => 'wp-dialog sierra-demo-popup',
			'resizable'   => false,
			'height'      => 'auto',
			'modal'       => true,
		) );
	}
	add_filter( 'pt-ocdi/confirmation_dialog_options', 'sierra_demo_dialog_options', 10, 1 );
}

function sierra_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'WP Sierra Demo Import' , 'sierra-addons' );
	$default_settings['menu_title']  = esc_html__( 'WP Sierra Demos' , 'sierra-addons' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pt-one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'sierra_plugin_page_setup' );
