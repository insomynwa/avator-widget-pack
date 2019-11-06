<?php
namespace WidgetPack\Modules\PriceList\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_List extends Widget_Base {

	public function get_name() {
		return 'avt-price-list';
	}

	public function get_title() {
		return AWP . esc_html__( 'Price List', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-price-list';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'price', 'lsit', 'rate', 'cost', 'value' ];
	}

	public function get_style_depends() {
		return [ 'wipa-price-list' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/QsXkIYwfXt4';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_list',
			[
				'label' => esc_html__( 'List', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'price_list',
			[
				'label'  => esc_html__( 'List Items', 'avator-widget-pack' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name'    => 'price',
						'label'   => esc_html__( 'Price', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXT,
						'dynamic' => [ 'active' => true ],
					],
					[
						'name'        => 'title',
						'label'       => esc_html__( 'Title', 'avator-widget-pack' ),
						'default'     => esc_html__( 'First item on the list', 'avator-widget-pack' ),
						'type'        => Controls_Manager::TEXT,
						'label_block' => 'true',
						'dynamic'     => [ 'active' => true ],
					],
					[
						'name'    => 'item_description',
						'label'   => esc_html__( 'Description', 'avator-widget-pack' ),
						'type'    => Controls_Manager::TEXTAREA,
						'dynamic' => [ 'active' => true ],
					],
					[
						'name'    => 'image',
						'label'   => esc_html__( 'Image', 'avator-widget-pack' ),
						'type'    => Controls_Manager::MEDIA,
						'default' => [],
						'dynamic' => [ 'active' => true ],
					],
					[
						'name'    => 'link',
						'label'   => esc_html__( 'Link', 'avator-widget-pack' ),
						'type'    => Controls_Manager::URL,
						'default' => [ 'url' => '#' ],
						'dynamic' => [ 'active' => true ],
					],
				],
				'default' => [
					[
						'title' => esc_html__( 'First item on the list', 'avator-widget-pack' ),
						'price' => '$20',
						'link'  => [ 'url' => '#' ],
					],
					[
						'title' => esc_html__( 'Second item on the list', 'avator-widget-pack' ),
						'price' => '$9',
						'link'  => [ 'url' => '#' ],
					],
					[
						'title' => esc_html__( 'Third item on the list', 'avator-widget-pack' ),
						'price' => '$32',
						'link'  => [ 'url' => '#' ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
            'section_style_item_style',
            [
                'label'      => esc_html__( 'Item Style', 'avator-widget-pack' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'row_gap',
            [
                'label' => esc_html__( 'Rows Gap', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'vertical_align',
            [
                'label'       => esc_html__( 'Vertical Align', 'avator-widget-pack' ),
                'type'        => Controls_Manager::SELECT,
                'description' => 'When you will take image then you understand its function',
                'options'     => [
                    'middle' => esc_html__( 'Middle', 'avator-widget-pack' ),
                    'top'    => esc_html__( 'Top', 'avator-widget-pack' ),
                    'bottom' => esc_html__( 'Bottom', 'avator-widget-pack' ),
                ],
                'default' => 'middle',
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'heading__title',
            [
                'label' => esc_html__( 'Title', 'avator-widget-pack' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .avt-price-list .avt-price-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .avt-price-list-header',
            ]
        );

        $this->add_control(
            'heading_item_description',
            [
                'label'     => esc_html__( 'Description', 'avator-widget-pack' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .avt-price-list-description',
            ]
        );

        $this->add_control(
            'heading_separator',
            [
                'label'     => esc_html__( 'Separator', 'avator-widget-pack' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'separator_style',
            [
                'label'   => esc_html__( 'Style', 'avator-widget-pack' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'solid'  => esc_html__( 'Solid', 'avator-widget-pack' ),
                    'dotted' => esc_html__( 'Dotted', 'avator-widget-pack' ),
                    'dashed' => esc_html__( 'Dashed', 'avator-widget-pack' ),
                    'double' => esc_html__( 'Double', 'avator-widget-pack' ),
                    'none'   => esc_html__( 'None', 'avator-widget-pack' ),
                ],
                'default'   => 'dashed',
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list-separator' => 'border-bottom-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_weight',
            [
                'label' => esc_html__( 'Weight', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list-separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 1,
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list-separator' => 'border-bottom-color: {{VALUE}};',
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'separator_spacing',
            [
                'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 40,
                    ],
                ],
                'condition' => [
                    'separator_style!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-price-list-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_image_style',
			[
				'label'      => esc_html__( 'Image Style', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-price-list-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .avt-price-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'body.rtl {{WRAPPER}} .avt-price-list-image'                              => 'padding-left: calc({{SIZE}}{{UNIT}}/2);',
					'body.rtl {{WRAPPER}} .avt-price-list-image + .avt-price-list-text'       => 'padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'body:not(.rtl) {{WRAPPER}} .avt-price-list-image'                        => 'padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'body:not(.rtl) {{WRAPPER}} .avt-price-list-image + .avt-price-list-text' => 'padding-left: calc({{SIZE}}{{UNIT}}/2);',
				],
				'default' => [
					'size' => 20,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'      => esc_html__( 'Price', 'avator-widget-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-price-list li:hover .avt-price-list-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#14ABF4',
				'selectors' => [
					'{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => esc_html__( 'Border', 'avator-widget-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .avt-price-list .avt-price-list-price',
			]
		);

		$this->add_control(
			'price_border_radius',
			[
				'label'   => esc_html__( 'Border Radius', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_width',
			[
				'label'   => esc_html__( 'Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'width: {{SIZE}}{{UNIT}}; text-align: center;',
				],
			]
		);

		$this->add_control(
			'price_height',
			[
				'label' => esc_html__( 'Height', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-price-list .avt-price-list-price' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; vertical-align: middle;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'price_box_shadow',
				'selector' => '{{WRAPPER}} .avt-price-list .avt-price-list-price',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Typography', 'avator-widget-pack' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .avt-price-list .avt-price-list-price',
			]
		);

		$this->end_controls_section();
	}

	private function render_image( $item, $settings ) {
		$image_id  = $item['image']['id'];
		$image_src = wp_get_attachment_image_src( $image_id, 'full' );
		$image_src = $image_src[0];

		return sprintf( '<img src="%s" alt="%s" />', $image_src, $item['title'] );
	}

	private function render_item_header( $item ) {
		$settings      = $this->get_settings_for_display();
		$url           = $item['link']['url'];
		$item_id       = $item['_id'];
		$avt_has_image = $item['image']['url'] ? 'avt-has-image ' : '';

        if ( $url ) {
            $unique_link_id = 'item-link-' . $item_id;

            $this->add_render_attribute( $unique_link_id, 'class', 'avt-grid avt-flex-'. esc_attr($settings['vertical_align']) );
            $this->add_render_attribute( $unique_link_id, 'class', esc_attr($avt_has_image) );


            $target = $item['link']['is_external'] ? '_blank' : '_self';

            $this->add_render_attribute( $unique_link_id, 'onclick', "window.open('" . $url . "', '$target')" );

			return '<li class="avt-price-list-item"><div ' . $this->get_render_attribute_string( $unique_link_id ) . 'avt-grid>';
		} else {
			return '<li class="avt-price-list-item avt-grid avt-grid-small '.esc_attr($avt_has_image).'avt-flex-'. esc_attr($settings['vertical_align']) .'" avt-grid>';
		}
	}

	private function render_item_footer( $item ) {
		if ( $item['link']['url'] ) {
			return '</div></li>';
		} else {
			return '</li>';
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<ul class="avt-price-list">

		<?php foreach ( $settings['price_list'] as $item ) :
			echo $this->render_item_header( $item );

			if ( ! empty( $item['image']['url'] ) ) : ?>
				<div class="avt-price-list-image avt-width-auto">
					<?php echo $this->render_image( $item, $settings ); ?>
				</div>
			<?php endif; ?>

			<div class="avt-price-list-text avt-width-expand">
				<div>
					<div class="avt-price-list-header avt-grid avt-grid-small avt-flex-middle" avt-grid>
						<span class="avt-price-list-title"><?php echo esc_html($item['title']); ?></span>

						<?php if ( 'none' != $settings['separator_style'] ) : ?>
							<span class="avt-price-list-separator avt-width-expand"></span>
						<?php endif; ?>

					</div>

                    <?php if ( $item['item_description'] ) : ?>
                        <p class="avt-price-list-description"><?php echo $this->parse_text_editor($item['item_description']); ?></p>
                    <?php endif; ?>
				</div>
			</div>
			<div class="avt-width-auto avt-flex-inline">
				<span class="avt-price-list-price"><?php echo esc_html($item['price']); ?></span>
			</div>

			<?php echo $this->render_item_footer( $item ); ?>

		<?php endforeach; ?>

		</ul>
		<?php
	}

	protected function _content_template() {
		?>
		<ul class="avt-price-list">
			<#
				for ( var i in settings.price_list ) {
					var item = settings.price_list[i],
						item_open_wrap = '<li class="avt-price-list-item avt-grid avt-grid-small avt-flex-' + settings.vertical_align + '" avt-grid>',
						item_close_wrap = '</li>';
					if ( item.link.url ) {
						item_open_wrap = '<li class="avt-price-list-item"><div class="avt-grid avt-grid-small avt-flex-' + settings.vertical_align + '" href="' + item.link.url + '" class="avt-price-list-item avt-link-reset" avt-grid>';
						item_close_wrap = '</div></li>';
					} #>
					{{{ item_open_wrap }}}
					<# if ( item.image && item.image.id ) {

						var image = {
							id: item.image.id,
							url: item.image.url,
							size: settings.image_size,
							dimension: settings.image_custom_dimension,
						};

						var image_url = elementor.imagesManager.getImageUrl( image );

						if (  image_url ) { #>
							<div class="avt-price-list-image avt-width-auto"><img src="{{ image_url }}" alt="{{ item.title }}"></div>
						<# } #>

					<# } #>

					<div class="avt-price-list-text avt-width-expand">
						<div>
							<div class="avt-price-list-header avt-grid avt-grid-small avt-flex-middle" avt-grid>
								<span class="avt-price-list-title">{{{ item.title }}}</span>
								<span class="avt-price-list-separator avt-width-expand"></span>
							</div>
							<p class="avt-price-list-description">{{{ item.item_description }}}</p>
						</div>
					</div>
					<div class="avt-width-auto avt-flex-inline">
						<span class="avt-price-list-price">{{{ item.price }}}</span>
					</div>
					{{{ item_close_wrap }}}
			 <# } #>
		</ul>
	<?php }
}
