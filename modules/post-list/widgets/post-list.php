<?php
namespace WidgetPack\Modules\PostList\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post_List extends Widget_Base {

	public function get_name() {
		return 'avt-post-list';
	}

	public function get_title() {
		return AWP . esc_html__( 'Post List', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-post-list';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'post', 'list', 'blog', 'recent', 'news' ];
	}

	public function get_style_depends() {
		return [ 'wipa-post-list' ];
	}

	// public function get_custom_help_url() {
	// 	return 'https://youtu.be/kFEL4AGnIv4';
	// }

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_horizontal',
			[
				'label' => esc_html__( 'Horizontal Layout', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'column',
			[
				'label'       => esc_html__( 'Column', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => 'For good looking set it 1 for default skin and 2 for another skin',
				'options'     => [
					'2' => esc_html__( 'Two', 'avator-widget-pack' ),
					'3' => esc_html__( 'Three', 'avator-widget-pack' ),
					'4' => esc_html__( 'Four', 'avator-widget-pack' ),
				],
				'condition' => [
					'show_horizontal' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'   => esc_html__( 'Divider', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'space_between',
			[
				'label'      => esc_html__( 'Space Between', 'avator-widget-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'separator' => 'before',
				'selectors' => [
				'{{WRAPPER}} .avt-post-list .avt-list > li:nth-child(n+2)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: {{SIZE}}{{UNIT}};',				
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-3\@m li:nth-child(n+4)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',		
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-2\@m li:nth-child(n+3)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',		
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-4\@m li:nth-child(n+5)' => 'margin-top: {{SIZE}}{{UNIT}}; padding-top: 0;',
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-2\@m li:nth-child(n+3) > div' => 'padding-top: {{SIZE}}{{UNIT}};',				
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-3\@m li:nth-child(n+4) > div' => 'padding-top: {{SIZE}}{{UNIT}};',				
				'{{WRAPPER}} .avt-post-list .avt-child-width-1-4\@m li:nth-child(n+5) > div' => 'padding-top: {{SIZE}}{{UNIT}};',					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => _x( 'Source', 'Posts Query Control', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__( 'Show All', 'avator-widget-pack' ),
					'by_name' => esc_html__( 'Manual Selection', 'avator-widget-pack' ),
				],
			]
		);

		$post_categories = get_terms( 'category' );

		$post_options = [];
		foreach ( $post_categories as $category ) {
			$post_options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'post_categories',
			[
				'label'       => esc_html__( 'Categories', 'avator-widget-pack' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $post_options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source'    => 'by_name',
				],
			]
		);

		$this->add_control(
			'posts_limit',
			[
				'label'   => esc_html__( 'Posts Limit', 'avator-widget-pack' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'     => esc_html__( 'Date', 'avator-widget-pack' ),
					'title'    => esc_html__( 'Title', 'avator-widget-pack' ),
					'category' => esc_html__( 'Category', 'avator-widget-pack' ),
					'rand'     => esc_html__( 'Random', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'avator-widget-pack' ),
					'ASC'  => esc_html__( 'Ascending', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'list_layout_image_size',
			[
				'label' => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 64,
						'max'  => 150,
						'step' => 10,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img'
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => __('Padding', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => __('Margin', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img'
			]
		);

		$this->add_control(
			'image_radius',
			[
				'label'      => __('Radius', 'avator-widget-pack'),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'after',
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'image_shadow',
				'selector'  => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img'
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'image_hover_background',
			[
				'label'     => __('Background', 'avator-widget-pack'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail:hover img' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'image_hover_border_color',
			[
				'label'     => __('Border Color', 'avator-widget-pack'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail:hover img' => 'border-color: {{VALUE}};'
				],
				'condition' => [
					'image_border_border!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail:hover img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => __( 'Opacity', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-thumbnail:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_list',
			[
				'label' => esc_html__( 'List Style', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);		

		$this->add_control(
			'list_layout_title_category',
			[
				'label' => esc_html__( 'Title', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'list_layout_title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-title .avt-post-list-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_layout_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-title .avt-post-list-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-title .avt-post-list-link',

			]
		);

		$this->add_control(
			'date_heading',
			[
				'label'     => esc_html__( 'Date', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_date' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta span:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'date_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta span',
				'condition' => [
					'show_date' => 'yes',
				],
				
			]
		);

		$this->add_control(
			'category_heading',
			[
				'label'     => esc_html__( 'Category', 'avator-widget-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_category' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'category_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'category_typography',
				'label'     => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .avt-post-list .list-part .avt-post-list-meta a',
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-post-list .avt-has-divider li > div'             => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .avt-post-list .avt-list-divider > li:nth-child(n+2)' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'show_divider' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		
		$settings = $this->get_settings();
		$id       = $this->get_id();
		

		if ( $settings['show_horizontal'] ) {
			$this->add_render_attribute('list-wrapper', 'avt-grid', '' );
			$this->add_render_attribute('list-wrapper', 'class', ['avt-grid', 'avt-child-width-1-' . $settings['column'] . '@m'] );
		} else {
			$this->add_render_attribute('list-wrapper', 'class', ['avt-list', 'avt-list-large'] );
		}

		$this->add_render_attribute('list-wrapper', 'class', ['avt-post-list-item', 'list-part'] );

		if ( $settings['show_divider'] ) {
			if ( $settings['show_horizontal'] ) {
				$this->add_render_attribute('list-wrapper', 'class', 'avt-has-divider' );
			} else {
				$this->add_render_attribute('list-wrapper', 'class', 'avt-list-divider' );
			}
		}

		$args = array(
			'posts_per_page' => $settings['posts_limit'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish'
		);
		
		if ( 'by_name' === $settings['source'] ) :
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		endif;

		$wp_query = new \WP_Query($args);

		if( $wp_query->have_posts() ) :

			?> 
			<div id="avt-post-list-<?php echo esc_attr($id); ?>" class="avt-post-list avt-post-list-skin-base">
		  		<div avt-scrollspy="cls: avt-animation-fade; target: > ul > .avt-post-list-item; delay: 350;">
		  			<ul <?php echo $this->get_render_attribute_string('list-wrapper'); ?>>
						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
							
							$placeholder_image_src = Utils::get_placeholder_image_src();
							$image_src             = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );

							if ( ! $image_src ) {
								$image_src = $placeholder_image_src;
							} else {
								$image_src = $image_src[0];
							}

							?>
				  			<li <?php echo $this->get_render_attribute_string('list'); ?>>
					  			<div class="avt-post-list-item-inner">
						  			<div class="avt-grid avt-grid-small" avt-grid>
						  				<div class="avt-post-list-thumbnail avt-width-auto">
						  					<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
							  					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
							  				</a>
						  				</div>
								  		<div class="avt-post-list-desc avt-width-expand">
											<?php if ($settings['show_title']) : ?>
												<h4 class="avt-post-list-title">
													<a href="<?php echo esc_url(get_permalink()); ?>" class="avt-post-list-link" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()) ; ?></a>
												</h4>
											<?php endif ?>

							            	<?php if ($settings['show_category'] or $settings['show_date']) : ?>

												<div class="avt-post-list-meta avt-subnav avt-flex-middle">
													<?php if ($settings['show_date']) : ?>
														<?php echo '<span>'.esc_attr(get_the_date('d F Y')).'</span>'; ?>
													<?php endif ?>

													<?php if ($settings['show_category']) : ?>
														<?php echo '<span>'.get_the_category_list(', ').'</span>'; ?>
													<?php endif ?>
													
												</div>

											<?php endif ?>
								  		</div>
									</div>
								</div>
							</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
			</div>
		
		 	<?php
		endif;
	}
}