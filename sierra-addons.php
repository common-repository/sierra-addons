<?php
/*
Plugin Name: Sierra Addons
Description: Plugin with extra features for WP Sierra theme.
Version: 1.0.20
Author: Themesty
Author URI: http://themesty.com
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! function_exists( 'sierra_addons_fs' ) ) {
    // Create a helper function for easy SDK access.
    function sierra_addons_fs() {
        global $sierra_addons_fs;

        if ( ! isset( $sierra_addons_fs ) ) {
            // Include Freemius SDK.
            $theme_root = get_theme_root();
            if ( file_exists( $theme_root . '/wp-sierra/freemius/start.php' ) ) {
                // Try to load SDK from parent theme's folder.
                require_once $theme_root . '/wp-sierra/freemius/start.php';
            } else {
                require_once dirname(__FILE__) . '/freemius/start.php';
            }

            $sierra_addons_fs = fs_dynamic_init( array(
                'id'                  => '2973',
                'slug'                => 'sierra-addons',
                'premium_slug'        => 'sierra-addons-pro',
                'type'                => 'plugin',
                'public_key'          => 'pk_f6efe1b39b7d51c00b498e7a0cfcb',
                'is_premium'          => false,
                'has_paid_plans'      => false,
                'parent'              => array(
                    'id'         => '2565',
                    'slug'       => 'wp-sierra',
                    'public_key' => 'pk_f008883de2d70aea803633df9636f',
                    'name'       => 'WP Sierra',
                ),
                'menu'                => array(
                    'slug'           => 'wpsierra',
                    'first-path'     => 'themes.php?page=wpsierra',
                    'support'        => false,
                    'parent'         => array(
                        'slug' => 'themes.php',
                    ),
                ),
            ) );
        }

        return $sierra_addons_fs;
    }
}

function sierra_addons_fs_addon_init() {
  if ( !function_exists( 'wpsierra_fs' ) ) {
      if ( is_admin() ) {
          // Add error admin notice telling the add-on cannot work without the addon.
      }

      return;
  }

  // Init Freemius.
  sierra_addons_fs();

  // Init add-on.
  sierra_addons_init();
}

if ( 0 == did_action( 'after_setup_theme' ) ) {
    // Init add-on only after parent theme was loaded.
    add_action( 'after_setup_theme', 'sierra_addons_fs_addon_init' );
} else {
    /**
     * This makes sure that if the theme was already loaded
     * before the plugin, it will run Freemius right away.
     *
     * This is crucial for the plugin's activation hook.
     */
    sierra_addons_fs_addon_init();
}

function sierra_addons_init() {

	if ( did_action( 'plugins_loaded' ) ) {
			sierra_addons_load();
	} else {
			add_action( 'plugins_loaded', 'sierra_addons_load' );
	}
}


// Redirect to WP Sierra welcome page after activation
$sierratheme = wp_get_theme();
if ( 'wp-sierra' == $sierratheme->get( 'TextDomain' ) || 'wp-sierra' == $sierratheme->get( 'Template' ) && '1.0.13' <= $sierratheme->get( 'Version' ) ) {
	register_activation_hook(__FILE__, 'wpsierra_plugin_activate');
	add_action('admin_init', 'wpsierra_plugin_redirect');
}

if ( 'wp-sierra' == $sierratheme->get( 'TextDomain' ) || 'wp-sierra' == $sierratheme->get( 'Template' ) ) {
	// Load Demo Data
	require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'demo-data/demo-install.php';
}

function wpsierra_plugin_activate() {
	add_option('wpsierra_plugin_do_activation_redirect', true);
}

function wpsierra_plugin_redirect() {
if ( get_option('wpsierra_plugin_do_activation_redirect', false) ) {
		delete_option('wpsierra_plugin_do_activation_redirect');
		if( !isset( $_GET['activate-multi'] ) ) {
				wp_redirect( 'themes.php?page=wpsierra' );
		}
 }
}


function sierra_addons_notice() {
	$message      = esc_html__( 'Sierra Addons requires the Elementor page builder to be active. Please activate Elementor to continue.', 'sierra-addons' );
	$html_message = sprintf( '<div class="notice notice-info is-dismissible">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}


function sierra_addons_load() {


	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		add_action( 'admin_notices', 'sierra_addons_notice' );
		return;
	}

	define( 'SIERRA_ADDONS_URL', __FILE__ );

	load_plugin_textdomain( 'sierra-addons', false, basename( dirname( __FILE__ ) ) . '/languages' );

	$theme = wp_get_theme();
	if ( 'wp-sierra' == $theme->get( 'TextDomain' ) || 'wp-sierra' == $theme->get( 'Template' ) ) {


		// Load Sierra Welcome Page
		if ( '1.0.45' <= $theme->get( 'Version' ) ) {
			require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'inc/sierra-welcome.php';
		}

		// Load ButterBean metaboxes
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'inc/butterbean/butterbean.php';

		// Load Sierra metaboxes
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'inc/metaboxes.php';


		// Add WP Sierra Widgets to Elementor
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . '/sierra-elementor.php';
	}

}

// Update CSS within in Admin
function wpsierra_addons_admin_style() {
	wp_enqueue_style( 'sierra-welcome-css', plugin_dir_url( __FILE__ ) . 'assets/css/sierra-welcome.css' );
}
add_action('admin_enqueue_scripts', 'wpsierra_addons_admin_style');



//Sierra Social Buttons


add_action( 'wpsierra_single_post_social', 'sierra_social_buttons' );

function sierra_social_buttons() {
		global $post;
?>
<div class="sierra-social">
		<div class="sierra-social-buttons">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="fa fa-facebook"></i>
				</a>
		</div>
		<div class="sierra-social-buttons">
				<a href="https://twitter.com/intent/tweet?text=<?php esc_html( sanitize_title_with_dashes( the_title( '', '', false ) ) ) ; ?>&url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="fa fa-twitter"></i>
				</a>
		</div>
		<div class="sierra-social-buttons">
				<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&description=<?php esc_html( sanitize_title_with_dashes( the_title( '', '', false ) ) ) ; ?>&media=<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
										<i class="fa fa-pinterest-p"></i>
								</a>
		</div>
		<div class="sierra-social-buttons">
				<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="fa fa-google-plus"></i>
				</a>
		</div>
		<div class="sierra-social-buttons">
				<a href="mailto:?Subject=<?php esc_html( sanitize_title_with_dashes( the_title( '', '', false ) ) ) ; ?>&body=<?php the_permalink(); ?>" target="_top">
						<i class="fa fa-paper-plane-o"></i>
				</a>
		</div>
</div>
<?php
	}
