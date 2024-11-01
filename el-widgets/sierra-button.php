<?php
namespace WPSierraElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

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
class WPSierra_Button extends Widget_Base {

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
		return 'sierra-button';
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
		return __( 'WP Sierra Button', 'sierra-addons' );
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
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'wp-sierra-widgets' ];
	}

  /**
   * Get button sizes.
   *
   * Retrieve an array of button sizes for the button widget.
   *
   * @since 1.0.0
   * @access public
   * @static
   *
   * @return array An array containing button sizes.
   */
  public static function get_button_sizes() {
    return [
      'xs' => __( 'Extra Small', 'sierra-addons' ),
      'sm' => __( 'Small', 'sierra-addons' ),
      'md' => __( 'Medium', 'sierra-addons' ),
      'lg' => __( 'Large', 'sierra-addons' ),
      'xl' => __( 'Extra Large', 'sierra-addons' ),
    ];
  }

	/**
	 * Register icon widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Button', 'sierra-addons' ),
			]
		);

    $this->add_control(
			'button_type',
			[
				'label' => __( 'Type', 'sierra-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => __( 'Default', 'sierra-addons' ),
					'arrow' => __( 'Link', 'sierra-addons' ),
				],
				'prefix_class' => 'sierra-button-',
			]
		);

    $this->add_control(
			'text',
			[
				'label' => __( 'Text', 'sierra-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click here', 'sierra-addons' ),
				'placeholder' => __( 'Click here', 'sierra-addons' ),
			]
		);

    $this->add_control(
			'link',
			[
				'label' => __( 'Link', 'sierra-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'sierra-addons' ),
				'default' => [
					'url' => '#',
				],
			]
		);

    $this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'sierra-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'sierra-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sierra-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sierra-addons' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'sierra-addons' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

    $this->add_control(
			'size',
			[
				'label' => __( 'Size', 'sierra-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

    $this->add_control(
			'new_icon',
			[
				'label' => __( 'Icon', 'sierra-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block' => true,
				'default' => [
						'value' => '',
						'library' => 'solid',
					],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'sierra-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => __( 'Before', 'sierra-addons' ),
					'right' => __( 'After', 'sierra-addons' ),
				],

			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'sierra-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sierra-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .sierra-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'sierra-addons' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'sierra-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'sierra-addons' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'sierra-addons' ),
				'separator' => 'before',

			]
		);

		$this->end_controls_section();

    $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'sierra-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'typography',
        'scheme' => Scheme_Typography::TYPOGRAPHY_4,
        'selector' => '{{WRAPPER}} a.sierra-button, {{WRAPPER}} .sierra-button',
      ]
    );

    $this->start_controls_tabs( 'tabs_button_style' );

    $this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'sierra-addons' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'sierra-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.sierra-button, {{WRAPPER}} .sierra-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'sierra-addons' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.sierra-button, {{WRAPPER}} .sierra-button' => 'background-color: {{VALUE}};',
				],
			]
		);

    $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .sierra-button',
			]
		);

		$this->end_controls_tab();

    $this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'sierra-addons' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'sierra-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.sierra-button:hover, {{WRAPPER}} .sierra-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'sierra-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.sierra-button:hover, {{WRAPPER}} .sierra-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'sierra-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.sierra-button:hover, {{WRAPPER}} .sierra-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .sierra-button:hover',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'sierra-addons' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .sierra-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'sierra-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.sierra-button, {{WRAPPER}} .sierra-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'sierra-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.sierra-button, {{WRAPPER}} .sierra-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render icon widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
   protected function render() {
 		$settings = $this->get_settings_for_display();

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['icon'] );

 		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

 		if ( ! empty( $settings['link']['url'] ) ) {
 			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
 			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

 			if ( $settings['link']['is_external'] ) {
 				$this->add_render_attribute( 'button', 'target', '_blank' );
 			}

 			if ( $settings['link']['nofollow'] ) {
 				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
 			}
 		}

 		$this->add_render_attribute( 'button', 'class', 'sierra-button' );
 		$this->add_render_attribute( 'button', 'role', 'button' );

 		if ( ! empty( $settings['button_css_id'] ) ) {
 			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
 		}

 		if ( ! empty( $settings['size'] ) ) {
 			$this->add_render_attribute( 'button', 'class', 'sierra-size-' . $settings['size'] );
 		}

 		if ( $settings['hover_animation'] ) {
 			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
 		}

 		?>
 		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
 			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
 				<?php $this->render_text(); ?>
 			</a>
 		</div>
 		<?php
 	}

	/**
	 * Render icon widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
   protected function _content_template() {
 		?>
 		<#
 		view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );

 		view.addInlineEditingAttributes( 'text', 'none' );
 		#>
		<# var iconHTML = elementor.helpers.renderIcon( view, settings.new_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
 		<div class="elementor-button-wrapper">
 			<a id="{{ settings.button_css_id }}" class="sierra-button sierra-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}" role="button">
 				<span class="elementor-button-content-wrapper">
					<# if ( iconHTML.rendered && ! settings.icon ) { #>
						<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
							{{{ iconHTML.value }}}
						</span>
					<# } else { #>
						<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						</span>
					<# } #>
 					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
 				</span>
 			</a>
 		</div>
 		<?php
 	}

  /**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		// Check if its already migrated
		$migrated = isset( $settings['__fa4_migrated']['new_icon'] );
		// Check if its a new widget without previously selected icon using the old Icon control
		$is_new = empty( $settings['icon'] );

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['new_icon'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php
				if ( $is_new || $migrated ) {
					\Elementor\Icons_Manager::render_icon( $settings['new_icon'], [ 'aria-hidden' => 'true' ] );
				} else {
					?>
					<i class="<?php echo $settings['icon']; ?>" aria-hidden="true"></i>
					<?php
				}
			?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
		</span>
		<?php
	}
}
