<?php
namespace WPSierraElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor icon widget.
 *
 * Elementor widget that displays an icon from over 600+ icons.
 *
 * @since 1.0.0
 */
class WPSierra_Posts extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sierra-posts';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'WP Sierra Posts', 'sierra-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */

	//public function get_keywords() {
		//return [ 'image', 'photo', 'visual', 'carousel', 'slider' ];
	//}

	public function get_script_depends() {
		return [ 'sierra-elementor-widgets' ];
	}


	public function get_categories() {
		return [ 'wp-sierra-widgets' ];
	}

	/**
	 * Get post type categories.
	 */
	private function sierra_all_post_type_categories( $post_type ) {
		$options = array( '' => 'All' );

		if ( $post_type == 'post' ) {
			$taxonomy = 'category';
		}

		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => true,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}


	/**
	 * Register Elementor Controls.
	 */
	protected function _register_controls() {
		// Content.
		$this->sierra_options_section();
	}

	/**
	 * Content > Grid.
	 */
	private function sierra_options_section() {
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Options', 'sierra-addons' ),
			]
		);


		// Post categories.
		$this->add_control(
			'grid_post_categories',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => __( 'Category', 'sierra-addons' ),
				'options'   => $this->sierra_all_post_type_categories( 'post' ),
				'default'		=> '',
			]
		);

		// Style.
		$this->add_control(
			'blog_style',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => __( 'Style', 'sierra-addons' ),
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'sierra-addons' ),
					'modern' => esc_html__( 'Modern', 'sierra-addons' ),
					'lines' 	 =>	esc_html__( 'Lines', 'sierra-addons' ),
				],
			]
		);

		// Items.
		$this->add_control(
			'grid_items',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => __( 'Items', 'sierra-addons' ),
				'placeholder' => __( 'How many items?', 'sierra-addons' ),
				'default'     => 3,
			]
		);

		// Columns.
		$this->add_control(
			'grid_columns',
			[
				'type'           => \Elementor\Controls_Manager::SELECT,
				'label'          => __( 'Columns', 'sierra-addons' ),
				'default'        => 'col3',
				'options'        => [
					'col1' => 1,
					'col2' => 2,
					'col3' => 3,
					'col4' => 4,
					'col5' => 5,
				],
			]
		);

		// Order by.
		$this->add_control(
			'grid_order_by',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => __( 'Order by', 'sierra-addons' ),
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'sierra-addons' ),
					'title'         => __( 'Title', 'sierra-addons' ),
					'modified'      => __( 'Modified date', 'sierra-addons' ),
					'comment_count' => __( 'Comment count', 'sierra-addons' ),
					'rand'          => __( 'Random', 'sierra-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_typo_section_style',
			[
				'label' => __( 'Title', 'sierra-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'title_typography',
        'scheme' => Scheme_Typography::TYPOGRAPHY_4,
        'selector' => '{{WRAPPER}} .post-list-title',
      ]
    );

		$this->end_controls_section();

		$this->start_controls_section(
			'excerpt_typo_section_style',
			[
				'label' => __( 'Excerpt', 'sierra-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'excerpt_typography',
        'scheme' => Scheme_Typography::TYPOGRAPHY_4,
        'selector' => '{{WRAPPER}} .post-excerpt p',
      ]
    );

		$this->end_controls_section();
	}


	/**
	 * Render function to output the post type grid.
	 */
	protected function render() {
		// Get settings.
		$settings = $this->get_settings_for_display();

		// Arguments for query.
		$args = array();

		// Display only published posts.
		$args['post_status'] = 'publish';

		// Ignore sticky posts.
		$args['ignore_sticky_posts'] = 1;

		// Check if post type exists.
		if ( post_type_exists( 'post' ) ) {
			$args['post_type'] = 'post';
		}

		// Display posts in category.
		if ( ! empty( $settings['grid_post_categories'] ) ) {
			$args['category_name'] = $settings['grid_post_categories'];
		}


		// Items to display.
		if ( ! empty( $settings['grid_items'] ) && intval( $settings['grid_items'] ) == $settings['grid_items'] ) {
			$args['posts_per_page'] = $settings['grid_items'];
		}

		// Order by.
		if ( ! empty( $settings['grid_order_by'] ) ) {
			$args['orderby'] = $settings['grid_order_by'];
		}


		// Query.
		$query = new \WP_Query( $args );
				// Query results.
				if ( $query->have_posts() ) {

          ?>
          <div class="masonry-container <?php echo  esc_attr( wpsierra_archive_blog_margin() ) ; ?>">
          <?php
					while ( $query->have_posts() ) {
						$query->the_post();
						?>


            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

              <div class="item <?php  echo  esc_attr( $settings['grid_columns'] ) ; ?>">

                <?php
								if ( 'default' == $settings['blog_style'] ) {
								  wpsierra_archive_blog_style();
								} elseif ( 'modern' == $settings['blog_style'] ) {
									wpsierra_blog_style_modern( 'large' );
								} elseif ( 'lines' == $settings['blog_style'] ) {
									wpsierra_blog_style_lines( 'large' );
								}

								?>

              </div><!--/.item-->

            </article>
						<?php

					} // End while().

          ?>
        </div>
          <?php

				} // End if().


		// Restore original data.
		wp_reset_postdata();

		?>

<?php

	}

  protected function _content_template() {
  }
	public function render_plain_content( $instance = [] ) {}

}
