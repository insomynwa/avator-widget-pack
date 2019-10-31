<?php
namespace WidgetPack\Modules\CryptoCurrency\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CryptoCurrencyTable extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-crypto-currency-table';
	}

	public function get_title() {
		return AWP . esc_html__( 'Crypto Currency Table', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-cryptocurrency-table';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'cryptocurrency', 'crypto', 'currency', 'table' ];
	}

	public function get_style_depends() {
		return ['avt-crypto-currency'];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_cryptocurrency',
			[
				'label' => esc_html__( 'Crypto Currency', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'crypto_currency',
			[
				'label'       => __( 'Crypto Currency', 'avator-widget-pack' ),
				'description'       => __( 'If you want to show any selected crypto currency in your table so type those currency name here. For example: bitcoin,ethereum,litecoin', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'bitcoin,ethereum' , 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'currency',
			[
				'label'       => __( 'Currency', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'usd' , 'avator-widget-pack' ),
				'placeholder' => __( 'usd' , 'avator-widget-pack' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'market_cap_desc',
				'options' => [
					'market_cap_desc' => esc_html__( 'Market Capital Descending', 'avator-widget-pack' ),
					'market_cap_asc'  => esc_html__( 'Market Capital Ascending', 'avator-widget-pack' ),
					'gecko_desc'      => esc_html__( 'Gecko Descending', 'avator-widget-pack' ),
					'gecko_asc'       => esc_html__( 'Gecko Ascending', 'avator-widget-pack' ),
					'volume_desc'     => esc_html__( 'Volume Descending', 'avator-widget-pack' ),
					'volume_asc'      => esc_html__( 'Volume Ascending', 'avator-widget-pack' ),
				],
			]
		);

		$this->add_responsive_control(
			'limit',
			[
				'label' => __( 'Limit', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 250,
					],
				],
				'default' => [
					'size' => 100,
				],
			]
		);

		$this->add_control(
			'show_stripe',
			[
				'label'   => __( 'Row Stripe', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_row_hover',
			[
				'label' => __( 'Row Hover', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'table_responsive_control',
			[
				'label'   => __( 'Responsive', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'table_responsive_2',
				'options' => [
					'table_responsive_no'     => esc_html__('No Responsive', 'avator-widget-pack'),
					'table_responsive_1' 	  => esc_html__('Responsive 1', 'avator-widget-pack'),
					'table_responsive_2' 	  => esc_html__('Responsive 2', 'avator-widget-pack'),
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_additional_option',
			[
				'label' => __( 'Additional Option', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'show_currency_image',
			[
				'label'   => __( 'Show Currency Image', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_name',
			[
				'label'   => __( 'Show Currency Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_short_name',
			[
				'label'   => __( 'Show Currency Short Name', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_marketing_rank',
			[
				'label'   => __( 'Show Marketing Rank', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_current_price',
			[
				'label'   => __( 'Show Current Price', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_change_price',
			[
				'label'   => __( 'Show Change Price', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_total_supply',
			[
				'label'   => __( 'Show Total Supply', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_market_cap',
			[
				'label'   => __( 'Show Market Cap', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_total_volume',
			[
				'label'   => __( 'Show Total Volume', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_circulating_supply',
			[
				'label'   => __( 'Show Circulating Supply', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cryptocurrency_table_header_style',
			[
				'label' => __( 'Table Header', 'avator-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_cryptocurrency_table_header_style' );

		$this->start_controls_tab(
			'tab_cryptocurrency_table_header_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
		'cryptocurrency_header_color',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cryptocurrency_header_background_color',
			[
				'label' => __( 'Background Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cryptocurrency_header_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
		'cryptocurrency_header_hover_color',
			[
				'label' => __( 'Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title:hover th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cryptocurrency_header_background_hover_color',
			[
				'label' => __( 'Background Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'header_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title th',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => __( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr.avt-cryptocurrency-title th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_body',
			[
				'label' => __( 'Table Body', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cell_border_style',
			[
				'label'   => __( 'Border Style', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => __( 'None', 'avator-widget-pack' ),
					'solid'  => __( 'Solid', 'avator-widget-pack' ),
					'double' => __( 'Double', 'avator-widget-pack' ),
					'dotted' => __( 'Dotted', 'avator-widget-pack' ),
					'dashed' => __( 'Dashed', 'avator-widget-pack' ),
					'groove' => __( 'Groove', 'avator-widget-pack' ),
				],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr td' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cell_border_width',
			[
				'label'   => __( 'Border Width', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 5,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr td' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => __( 'Cell Padding', 'avator-widget-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0.5,
					'bottom' => 0.5,
					'left'   => 1,
					'right'  => 1,
					'unit'   => 'em'
				],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs('tabs_body_style');

		$this->start_controls_tab(
			'tab_normal',
			[
				'label' => __( 'Normal', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'normal_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_border_color',
			[
				'label'     => __( 'Border Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table tbody tr td' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover',
			[
				'label' => __( 'Hover', 'avator-widget-pack' ),
				'condition' => [
					'show_row_hover' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_hover_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table .avt-table.avt-table-hover tbody tr:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'row_hover_text_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table .avt-table.avt-table-hover tbody tr:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stripe',
			[
				'label'     => __( 'Stripe', 'avator-widget-pack' ),
				'condition' => [
					'show_stripe' => 'yes',
				],
			]
		);

		$this->add_control(
			'stripe_background',
			[
				'label'     => __( 'Background', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table .avt-table-striped tbody tr:nth-of-type(odd)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stripe_color',
			[
				'label'     => __( 'Text Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table .avt-table-striped tbody tr:nth-of-type(odd)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_cryptocurrency_image_style',
			[
				'label' => __( 'Currency Image', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'show_currency_image' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			'logo_image_width',
			[
				'label' => __( 'Width', 'avator-widget-pack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr td img' => 'width: {{SIZE}}{{UNIT}};margin-left: auto;margin-right: auto;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cryptocurrency_name_style',
			[
				'label' => __( 'Currency Name', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_currency_name' => 'yes',
				],
			]
		);

		$this->add_control(
		'cryptocurrency_name_color',
			[
				'label' => __( 'Name Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr td .avt-cryptocurrency-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-table table tr td .avt-cryptocurrency-name',
			]
		);

		$this->add_control(
		'cryptocurrency_short_name_color',
			[
				'label' => __( 'Short Name Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr td .avt-currency-short-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'short_name_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-table table tr td .avt-currency-short-name',
			]
		);

		$this->add_responsive_control(
            'cryptocurrency_name_spacing',
            [
                'label' => esc_html__( 'Spacing', 'avator-widget-pack' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .avt-crypto-currency-table table tr td .avt-cryptocurrency-fullname' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cryptocurrency_text_style',
			[
				'label' => __( 'Currency Text', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'cryptocurrency_text_color',
			[
				'label' => __( 'Text Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-table table tr td',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-table table tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	protected function render_coin_api() {
		$settings        = $this->get_settings();
		$id              = $this->get_id();
		$crypto_currency = ($settings['crypto_currency']) ? $settings['crypto_currency'] : false;

		$api_url = 'https://api.coingecko.com/api/v3/coins/markets';


		// Parameters as array of key => value pairs
		$final_query =  add_query_arg( 
		    array( 
		        'vs_currency' => strtolower($settings['currency']),
		        'order'       => $settings['order'], //market_cap_desc
		        'per_page'    => $settings['limit']['size'], //limit
		        'page'        => 1,
		        'sparkline'   => 'false',
		        'ids'         => $crypto_currency,
		        
		    ), 
		    $api_url
		);



		$request = wp_remote_get($final_query, array('timeout' => 120));
		
		if (is_wp_error($request)) {
			return false; // Bail early
		}
		
		$body = wp_remote_retrieve_body($request);
		$coins = json_decode($body,true);
		
		// $saved_coins = get_transient( 'widget-pack-ccc' );

		// if (false == $saved_coins) {
		// 	set_transient( 'widget-pack-ccc', $coins, 5 * MINUTE_IN_SECONDS );
		// 	$coins = get_transient( 'widget-pack-ccc' );
		// }

		return $coins;

	}

	protected function render() {
		$settings = $this->get_settings();
		$id       = $this->get_id();
		$coins    = $this->render_coin_api();
		$currency = widget_pack_currency_symbol($settings['currency']);



		if ('table_responsive_no' == $settings['table_responsive_control']) {
			$this->add_render_attribute('crypto-table', 'class', ['avt-table']);
		}

		if ('table_responsive_1' == $settings['table_responsive_control']) {
			$this->add_render_attribute('crypto-table', 'class', ['avt-table', 'avt-table-responsive']);
		}
		
		if ('table_responsive_2' == $settings['table_responsive_control']) {
			$this->add_render_attribute('crypto-table', 'class', ['avt-table', 'avt-table-responsive-2']);
		}




		if ($settings['show_row_hover']) {
			$this->add_render_attribute('crypto-table', 'class', 'avt-table-hover');
		}

		if ($settings['show_stripe']) {
			$this->add_render_attribute('crypto-table', 'class', 'avt-table-striped');
		} else {
			$this->add_render_attribute('crypto-table', 'class', 'avt-table-divider');
		}
	   	

		?>

		<div class="avt-crypto-currency-table">

			<table <?php echo $this->get_render_attribute_string( 'crypto-table' ); ?>>
				
				<thead>
					<tr class="avt-cryptocurrency-title">

						<?php if ($settings['show_currency_marketing_rank']) : ?>
						<th><?php esc_html_e('#', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<th><?php esc_html_e('Currency', 'avator-widget-pack'); ?></th>

						<?php if ($settings['show_currency_current_price']) : ?>
						<th><?php echo esc_html( $currency ); ?> <?php esc_html_e('Price', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ($settings['show_currency_change_price']) : ?>
						<th><?php esc_html_e('24h % Change', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ($settings['show_currency_total_supply']) : ?>
						<th><?php esc_html_e('Supply', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ($settings['show_currency_market_cap']) : ?>
						<th><?php esc_html_e('Market cap.', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ($settings['show_currency_total_volume']) : ?>
						<th><?php esc_html_e('24h Volume', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

						<?php if ($settings['show_currency_circulating_supply']) : ?>
						<th><?php esc_html_e('Circulating Supply', 'avator-widget-pack'); ?></th>
						<?php endif; ?>

					</tr>
					
				</thead>
				

				<tbody>
					
					<?php foreach($coins as $coin) : ?>
						<tr class="avt-cryptocurrency-list">

							<?php if ($settings['show_currency_marketing_rank']) : ?>
							<td class="avt-table-shrink" title="<?php esc_html_e( 'Marketplace Rank', 'avator-widget-pack' ); ?>"><?php echo esc_html($coin['market_cap_rank']); ?></td>
							<?php endif; ?>

							<td>
								
								<?php if ($settings['show_currency_image']) : ?>
								<span class="avt-crypto-currency-image">
									<img src="<?php echo esc_attr($coin['image']); ?>"/>
								</span>
								<?php endif; ?>
								<span class="avt-cryptocurrency-fullname">
									<span class="avt-display-block">
										<?php if ($settings['show_currency_name']) : ?>
										<span class="avt-cryptocurrency-name"><?php echo esc_html( $coin['name'] ); ?>
										</span>
										<?php endif; ?>
									</span>
									<span class="avt-display-block avt-currency-short-name">
										<?php if ($settings['show_currency_short_name']) : ?>
										<span class="avt-text-uppercase"><?php echo esc_attr( $coin['symbol'] ); ?>
										</span>
										<?php endif; ?>
									</span>
								</span>
							</td>
							
							<?php if ($settings['show_currency_current_price']) : ?>
							<td><?php echo esc_html( $currency ); ?> <?php echo widget_pack_money_format($coin['current_price']); ?></td>
							<?php endif; ?>

							<?php if ($settings['show_currency_change_price']) : ?>
							<td><?php echo esc_html($coin['price_change_24h']); ?></td>
							<?php endif; ?>

							<?php if ($settings['show_currency_total_supply']) : ?>
							<td><?php echo esc_html($coin['total_supply']); ?></td>
							<?php endif; ?>

							<?php if ($settings['show_currency_market_cap']) : ?>
							<td><?php echo esc_html($coin['market_cap']); ?></td>
							<?php endif; ?>

							<?php if ($settings['show_currency_total_volume']) : ?>
							<td><?php echo esc_html($coin['total_volume']); ?></td>
							<?php endif; ?>

							<?php if ($settings['show_currency_circulating_supply']) : ?>
							<td><?php echo esc_html($coin['circulating_supply']); ?></td>
							<?php endif; ?>

						</tr>
					
					<?php endforeach; ?>

				</tbody>

	    	</table>

	    </div>
     
		<?php
	}
}

