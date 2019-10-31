<?php
namespace WidgetPack\Modules\Timeline\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

use WidgetPack\Modules\Timeline\Skins;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Timeline extends Widget_Base {
	public function get_name() {
		return 'avt-timeline';
	}

	public function get_title() {
		return AWP . esc_html__( 'Timeline', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-timeline';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'timeline', 'history', 'statistics' ];
	}

	public function get_script_depends() {
		return [ 'timeline' ];
	}

	public function _register_skins() {
		$this->add_skin( new Skins\Skin_Olivier( $this ) );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'timeline_source',
			[
				'label'   => esc_html__( 'Source', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
					'post'   => __( 'Post', 'avator-widget-pack' ),
					'custom' => __( 'Custom', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'timeline_align',
			[
				'label'   => esc_html__( 'Layout', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'toggle'  => false,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
				],
				'condition' => [
					'_skin' => '',
				]
			]
		);

		$this->add_control(
			'visible_items',
			[
				'label'     => esc_html__( 'Visible Items', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'condition' => [
					'_skin' => 'avt-olivier',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label'     => esc_html__( 'Query', 'avator-widget-pack' ),
				'condition' => [
					'timeline_source' => 'post',
				],
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
				'default' => 4,
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

		$this->start_controls_section(
			'section_custom_content',
			[
				'label'     => esc_html__( 'Custom Content', 'avator-widget-pack' ),
				'condition' => [
					'timeline_source' => 'custom'
				]
			]
		);

		$this->add_control(
			'timeline_items',
			[
				'label'   => esc_html__( 'Timeline Items', 'avator-widget-pack' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'timeline_title' 		=> esc_html__( 'This is Timeline Item 1 Title', 'avator-widget-pack' ),
						'timeline_text'  		=> esc_html__( 'I am timeline item content. Click edit button to change this text. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.', 'avator-widget-pack' ),
						'timeline_select_icon'  => ['value' => 'fas fa-file-alt', 'library' => 'fa-solid'],
					],
					[
						'timeline_title' 		=> esc_html__( 'This is Timeline Item 2 Title', 'avator-widget-pack' ),
						'timeline_text'  		=> esc_html__( 'I am timeline item content. Click edit button to change this text. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.', 'avator-widget-pack' ),
						'timeline_select_icon'  => ['value' => 'fas fa-file-alt', 'library' => 'fa-solid'],
					],
					[
						'timeline_title' 		=> esc_html__( 'This is Timeline Item 3 Title', 'avator-widget-pack' ),
						'timeline_text'  		=> esc_html__( 'I am timeline item content. Click edit button to change this text. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.', 'avator-widget-pack' ),
						'timeline_select_icon'  => ['value' => 'fas fa-file-alt', 'library' => 'fa-solid'],
					],
					[
						'timeline_title' 		=> esc_html__( 'This is Timeline Item 4 Title', 'avator-widget-pack' ),
						'timeline_text'  		=> esc_html__( 'I am timeline item content. Click edit button to change this text. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.', 'avator-widget-pack' ),
						'timeline_select_icon'  => ['value' => 'fas fa-file-alt', 'library' => 'fa-solid'],
					],
				],
				'fields' => [
					[
						'name'    => 'timeline_title',
						'label'   => esc_html__( 'Title', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => esc_html__( 'This is Timeline Item 1 Title' , 'avator-widget-pack' ),
					],
					[
						'name'    => 'timeline_date',
						'label'   => esc_html__( 'Date', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'default' => '31 December 2018',
					],
					[
						'name'    => 'timeline_image',
						'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'name'    => 'timeline_text',
						'label'   => esc_html__( 'Content', 'avator-widget-pack' ),
						'type'    => Controls_Manager::WYSIWYG,
						'default' => esc_html__( 'I am timeline item content. Click edit button to change this text. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.', 'avator-widget-pack' ),
					],
					[
						'name'        => 'timeline_link',
						'label'       => esc_html__( 'Button Link', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'placeholder' => __( 'https://avator.com', 'avator-widget-pack' ),
						'default'     => __( 'https://avator.com', 'avator-widget-pack' ),
					],
					[
						'name'    			=> 'timeline_select_icon',
						'label'   			=> esc_html__( 'Icon', 'avator-widget-pack' ),
						'type'        		=> Controls_Manager::ICONS,
						'fa4compatibility'  => 'timeline_icon',
						'default' 			=> [
							'value' 			=> 'fas fa-file-alt',
							'library' 			=> 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ timeline_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => esc_html__('Readmore Button', 'avator-widget-pack'),
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Read More', 'avator-widget-pack' ),
				'placeholder' => esc_html__( 'Read More', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Button Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
					'xs' => __( 'Extra Small', 'avator-widget-pack' ),
					'sm' => __( 'Small', 'avator-widget-pack' ),
					'md' => __( 'Medium', 'avator-widget-pack' ),
					'lg' => __( 'Large', 'avator-widget-pack' ),
					'xl' => __( 'Extra Large', 'avator-widget-pack' ),
				]
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' 			=> esc_html__( 'Button Icon', 'avator-widget-pack' ),
				'type'        		=> Controls_Manager::ICONS,
				'fa4compatibility'  => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Icon Position', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Before', 'avator-widget-pack' ),
					'right' => esc_html__( 'After', 'avator-widget-pack' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'   => esc_html__( 'Icon Spacing', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-timeline .avt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);	
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => esc_html__('Additional Options', 'avator-widget-pack')
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
			'title_link',
			[
				'label'     => esc_html__( 'Title Link', 'avator-widget-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'   => esc_html__( 'Meta Data', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'avator-widget-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'condition' => [
					'show_excerpt'    => 'yes',
					'timeline_source' => 'post',
				],
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'   => esc_html__( 'Read More', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3f3f3',
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-item-main'                  => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-arrow'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline-item--top .avt-timeline-content:after'    => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline-item--bottom .avt-timeline-content:after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline--mobile .avt-timeline-content:after'      => 'border-right-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-item-main',
			]
		);

		$this->add_control(
			'timeline_line_color',
			[
				'label'     => esc_html__( 'Line Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-divider'                               => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-line span'               => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline:not(.avt-timeline--horizontal):before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-item:after'              => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'timeline_line_width',
			[
				'label' => __( 'Line Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'default' => [
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-divider'                               => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-line span'               => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .avt-timeline-skin-olivier .avt-timeline-item:after' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline .avt-timeline-item-main',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-item-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_animation',
			[
				'label' => esc_html__( 'Scroll Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => ''
				]
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-icon span'
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => __( 'Width', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_show',
			[
				'label'        => esc_html__( 'Show Icon', 'avator-widget-pack' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 35,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span:before, {{WRAPPER}} .avt-timeline .avt-timeline-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_show' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline .avt-timeline-icon span',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span:hover:before, {{WRAPPER}} .avt-timeline .avt-timeline-icon span:hover i' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-icon span:hover:before' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[
				'label' => esc_html__( 'Date', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'date_background_color',
			[
				'label'     => esc_html__( 'background-Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3f3f3;',
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-date span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-date span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'date_shadow',
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-date span',
			]
		);

		$this->add_responsive_control(
			'date_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '10',
					'right'  => '15',
					'bottom' => '10',
					'left'   => '15',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-date span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'date_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline .avt-timeline-date span',
			]
		);

		$this->add_responsive_control(
			'date_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '2',
					'right'  => '2',
					'bottom' => '2',
					'left'   => '2',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-date span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'         => 'thumbnail_size',
				'label'        => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'exclude'      => [ 'custom' ],
				'default'      => 'medium',
				'prefix_class' => 'avt-timeline-thumbnail-size-',
			]
		);

		$this->add_responsive_control(
			'image_ratio',
			[
				'label'   => esc_html__( 'Image Height', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 265,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-thumbnail img' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'   => esc_html__( 'Opacity', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-thumbnail img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '0',
					'left'   => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline .avt-timeline-thumbnail',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-title *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-title *',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_meta',
			[
				'label'     => esc_html__( 'Meta', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#bbbbbb',
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-meta *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-meta *',
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#888888',
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-excerpt',
			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => esc_html__( 'Readmore Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-readmore',
			]
		);

		$this->add_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline .avt-timeline-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'readmore_spacing',
			[
				'label' => __( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-timeline .avt-timeline-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'readmore_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline .avt-timeline-readmore:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'avator-widget-pack' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation_button',
			[
				'label'     => esc_html__( 'Navigation Button', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => 'avt-olivier',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_button_style' );

		$this->start_controls_tab(
			'tab_navigation_button_normal',
			[
				'label' => esc_html__( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation_button_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-nav-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-nav-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'navigation_button_shadow',
				'selector' => '{{WRAPPER}} .avt-timeline-nav-button',
			]
		);

		$this->add_control(
			'navigation_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline-nav-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'navigation_button_border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-timeline-nav-button',
			]
		);

		$this->add_responsive_control(
			'navigation_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-timeline-nav-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_navigation_button_hover',
			[
				'label' => esc_html__( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'navigation_button_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-nav-button:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'navigation_button_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-nav-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'navigation_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .avt-timeline-nav-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'excerpt_length' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt( $item = [] ) {

		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( 'post' == $settings['timeline_source'] ) {
			add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
			add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

			?>
			<div class="avt-timeline-excerpt">
				<?php do_shortcode(the_excerpt()); ?>
			</div>
			<?php

			remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
			remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		} else {
			?>
			<div class="avt-timeline-excerpt">
				<?php echo do_shortcode($item['timeline_text']); ?>
			</div>
			<?php
		}

	}

	public function render_readmore( $item = [] ) {

		if ( ! $this->get_settings( 'show_readmore' ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( 'post' == $settings['timeline_source'] ) {
			$readmore_link = get_permalink();
		} else {
			$readmore_link = $item['timeline_link'];
		}

		$this->add_render_attribute(
			[
				'timeline-readmore' => [
					'href'  => esc_url( $readmore_link ),
					'class' => [
						'avt-timeline-readmore',
						'elementor-button',
						'elementor-size-' . esc_attr( $settings['button_size'] ),
						$settings['readmore_hover_animation'] ? 'elementor-animation-' . $settings['readmore_hover_animation'] : ''
					],
				]
			], '', '', true
		);

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
		$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<a <?php echo $this->get_render_attribute_string( 'timeline-readmore' ); ?>>
			<?php echo esc_html($settings['readmore_text']); ?>

			<?php if ($settings['button_icon']['value']) : ?>
				<span class="avt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

				</span>
			<?php endif; ?>
		</a>
		<?php

	}

	public function render_image( $item = [] ) {

		if ( ! $this->get_settings( 'show_image' ) ) {
			return;
		}

		$settings              = $this->get_settings_for_display();

		$placeholder_image_url = Utils::get_placeholder_image_src();

		if ( 'post' == $settings['timeline_source'] ) {
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			$title     = get_the_title();
		} else {
			$image_url = wp_get_attachment_image_src( $item['timeline_image']['id'], 'full' );
			$title     = $item['timeline_title'];
		}					

		if ( ! $image_url ) {
			$image_url = $placeholder_image_url;
		} else {
			$image_url = $image_url[0];
		}

		?>
  		<div class="avt-timeline-thumbnail">
  			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>">
  		</div>
  		<?php

	}

	public function render_title( $item = [] ) {

		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( 'post' == $settings['timeline_source'] ) {
			$title_link = get_permalink();
			$title      = get_the_title();
		} else {
			$title_link = $item['timeline_link'];
			$title      = $item['timeline_title'];
		}

		?>
		<h4 class="avt-timeline-title">
			<?php if ($settings['title_link']) : ?>
				<a href="<?php echo esc_url( $title_link ); ?>" title="<?php echo esc_html( $title ); ?>"><?php echo esc_html( $title ) ; ?></a>
			<?php else : ?>
				<span><?php echo esc_html( $title ) ; ?></span>
			<?php endif; ?>			
		</h4>
		<?php

	}

	public function render_meta( $align, $item = [] ) {

		if ( ! $this->get_settings( 'show_meta' ) ) {
			return;
		}

		$settings     = $this->get_settings_for_display();
		
		$meta_date    = '';		
		$hidden_class =  ('center' == $align) ? 'avt-hidden@m' : '';
		$meta_date    = '<li class="' . $hidden_class . '">'.esc_attr(get_the_date('d F Y')).'</li>';
		$meta_list    = '<li>'.get_the_category_list(', ').'</li>';

		?>
		<ul class="avt-timeline-meta avt-subnav avt-flex-middle">

			<?php if ( 'post' == $settings['timeline_source'] ) {
				echo wp_kses_post($meta_date);
				echo wp_kses_post($meta_list);
			} else {
				?>
				<li><?php echo esc_attr($item['timeline_date']); ?></li>
				<?php
			}			
			
		?>
		</ul>
		<?php

	}

	public function render_item( $item_parallax, $align, $item = [] ) {

		?>
		<div class="avt-timeline-item-main"<?php echo esc_attr($item_parallax); ?>>
			<span class="avt-timeline-arrow"></span>

			<?php $this->render_image( $item ); ?>

	  		<div class="avt-timeline-desc avt-padding">
				<?php $this->render_title( $item ); ?>
				<?php $this->render_meta( $align, $item ); ?>
				<?php $this->render_excerpt( $item ); ?>
				<?php $this->render_readmore( $item ); ?>
	  		</div>
		</div>
		<?php

	}

	public function render_date( $align = 'left', $item = [] ) {

		$settings = $this->get_settings_for_display();
		$date_parallax = '';

		if ( 'post' == $settings['timeline_source'] ) {
			$timeline_date = get_the_date('d F Y');
		} else {
			$timeline_date = $item['timeline_date'];
		}

		if ( $settings['item_animation'] ) {
			if ($align == 'right') {
				$date_parallax = ' avt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"';
			} else {
				$date_parallax = ' avt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"';
			}
		}

		?>
		<div class="avt-timeline-item avt-width-1-2@m avt-visible@m">
	  		<div class="avt-timeline-date avt-text-<?php echo esc_attr( $align ); ?>"<?php echo esc_attr($date_parallax); ?>><span><?php echo esc_attr( $timeline_date ); ?></span></div>
		</div>
		<?php

	}

	public function render_query() {
		$settings       = $this->get_settings_for_display();

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

		return $wp_query;
	}

	public function render_post() {
		$settings               = $this->get_settings_for_display();
		$id                     = $this->get_id();
		$align                  = $settings['timeline_align'];
		$icon_parallax          = ( $settings['item_animation'] ) ? ' avt-parallax="scale: 0.5,1; viewport: 0.5;"' : '';
		$vertical_line_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;viewport: 0.5;"' : '';

		$wp_query = $this->render_query();

		if( $wp_query->have_posts() ) :

			$this->add_render_attribute(
				[
					'avt-timeline' => [
						'id'    => 'avt-timeline-' . esc_attr($id),
						'class' => [
							'avt-timeline',
							'avt-timeline-skin-default',
							'avt-timeline-' . esc_attr($align)
						]
					]
				]
			);

			if ( 'yes' == $settings['icon_show'] ) {
				$this->add_render_attribute( 'avt-timeline',  'class',  'avt-timeline-icon-yes');
			}

			?> 
			<div <?php echo $this->get_render_attribute_string( 'avt-timeline' ); ?>>
				<div class="avt-grid avt-grid-collapse">
					<?php
					$avt_count = 0;
					while ( $wp_query->have_posts() ) : $wp_query->the_post();

						$avt_count++;						
						$post_format = get_post_format() ? : 'standard';
						$item_part   = ($avt_count%2 === 0) ? 'right' : 'left';

						if ('center' == $align) {
							$parallax_direction = ( $avt_count%2 === 0 ) ? '' : '-';

							$item_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity:0,1;x:'.$parallax_direction.'200,0;viewport: 0.5;"' : '';
						} elseif ('right' == $align) {
							$item_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"' : '';
						} else {
							$item_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"' : '';
						}

						if ( $avt_count%2 === 0 and 'center' == $align ) : ?>
							<?php $this->render_date( 'right', '' ); ?>					  		
						<?php endif; ?>

			  			<div class="<?php echo ('center' == $align) ? ' avt-width-1-2@m ' : ' '; ?>avt-timeline-item <?php echo esc_attr($item_part) . '-part'; ?>">
				  			
				  			<div class="avt-timeline-item-main-wrapper">
				  				<div class="avt-timeline-line"><span<?php echo esc_attr($vertical_line_parallax); ?>></span></div>
					  			<div class="avt-timeline-item-main-container">
					  				<div class="avt-timeline-icon avt-post-format-<?php echo esc_attr($post_format); ?>"<?php echo esc_attr($icon_parallax); ?>>
					  					<span></span>
					  				</div>

									<?php $this->render_item( $item_parallax, $align, '' ); ?>								

								</div>
							</div>
						</div>

					  	<?php if( $avt_count%2 === 1 and ('center' == $align) ) : ?>
							<?php $this->render_date( 'left', '' ); ?>					  		
						<?php endif; ?>

					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
			
 		<?php endif;
	}

	public function render_custom() {
		$id                     = $this->get_id();
		$settings               = $this->get_settings_for_display();
		$timeline_items         = $settings['timeline_items'];
		
		$align                  = $settings['timeline_align'];	
		$animation              = $settings['readmore_hover_animation'] ? ' elementor-animation-'.$settings['readmore_hover_animation'] : '';
		$vertical_line_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;viewport: 0.2;"' : '';

		$this->add_render_attribute( 'avt-timeline-custom',  'id',  'avt-timeline-' . esc_attr($id) );
		$this->add_render_attribute( 'avt-timeline-custom',  'class',  'avt-timeline avt-timeline-skin-default' );
		$this->add_render_attribute( 'avt-timeline-custom',  'class',  'avt-timeline-' . esc_attr($align) );
		
		?>
		<div <?php echo $this->get_render_attribute_string( 'avt-timeline-custom' ); ?> >
			<div class="avt-grid avt-grid-collapse" avt-grid>
				<?php
				$avt_count = 0;
				foreach ( $timeline_items as $item ) :
					$post_format   =  'standard';
					$timeline_date = '';
					$avt_count++;

					if ( ! isset( $item['timeline_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
						// add old default
						$item['timeline_icon'] = 'fas fa-file-alt';
					}

					$migrated  = isset( $item['__fa4_migrated']['timeline_select_icon'] );
					$is_new    = empty( $item['timeline_icon'] ) && Icons_Manager::is_migration_allowed();

					if ( 'center' == $align ) {
						$parallax_direction = ( $avt_count%2 === 0 ) ? '' : '-';
						$item_parallax      = ( $settings['item_animation'] ) ? ' avt-parallax="opacity:0,1;x:'.$parallax_direction.'200,0;viewport: 0.5;"' : '';
					} elseif ('right' == $align) {
						$item_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"' : '';
					} else {
						$item_parallax = ( $settings['item_animation'] ) ? ' avt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"' : '';
					}					

					$item_part = ( $avt_count%2 === 0 ) ? 'right' : 'left';

				  	if ( $avt_count%2 === 0 and 'center' == $align ) : ?>
			  			<?php $this->render_date( 'right', $item ); ?>
					<?php endif; ?>


	  				<div class="<?php echo ( 'center' == $align ) ? ' avt-width-1-2@m ' : ' '; ?>avt-timeline-item <?php echo esc_attr($item_part) . '-part'; ?>">
			  			
			  			<div class="avt-timeline-item-main-wrapper">
			  				<div class="avt-timeline-line"><span<?php echo esc_attr($vertical_line_parallax); ?>></span></div>
				  			<div class="avt-timeline-item-main-container">
			  					<?php $item_scrollspy = ( $settings['item_animation'] ) ? ' avt-scrollspy="cls: avt-animation-scale-up;"' : ''; ?>

				  				<div class="avt-timeline-icon"<?php echo esc_attr($item_scrollspy); ?>>
	
				  					<span>
				  						
				  					<?php if ( 'yes' == $settings['icon_show'] ) : ?>
					  					<?php if ( $is_new || $migrated ) :
											Icons_Manager::render_icon( $item['timeline_select_icon'], [ 'aria-hidden' => 'true' ] );
										else : ?>
											<i class="<?php echo esc_attr( $item['timeline_icon'] ); ?>" aria-hidden="true"></i>
										<?php endif; ?>
									<?php endif; ?>

				  					</span>

				  				</div>
					  			<?php $this->render_item( $item_parallax, $align, $item ); ?>
							</div>
						</div>
					</div>

				  	<?php if ( $avt_count%2 === 1 and ( 'center' == $align ) ) : ?>
						<?php $this->render_date( '', $item ); ?>
					<?php endif; ?>

				<?php endforeach; ?>

			</div>
		</div>
 		<?php
	}

	public function render() {

		$settings = $this->get_settings_for_display();

		if ( 'post'  === $settings['timeline_source'] ) {
			$this->render_post();
		} else if ( 'custom'  === $settings['timeline_source'] ) {
			$this->render_custom();
		} else {
			return;
		}
	}
}