<?php
namespace WidgetPack\Modules\CryptoCurrency\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CryptoCurrencyCard extends Widget_Base {

	protected $_has_template_content = false;

	public function get_name() {
		return 'avt-crypto-currency-card';
	}

	public function get_title() {
		return AWP . esc_html__( 'Crypto Currency Card', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-crypto-currency-card';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'cryptocurrency', 'crypto', 'currency', 'table' ];
	}

	public function get_style_depends() {
		return ['wipa-crypto-currency'];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/TnSjwUKrw00';
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
				'default' 	  => 'bitcoin',
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
			'show_currency_marketing_rank',
			[
				'label'   => __( 'Show Marketing Rank', 'avator-widget-pack' ),
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
				'label'   => __( 'Show 24h Volume', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_currency_high_low',
			[
				'label'   => __( 'Show 24h High/Low', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		//Style

		$this->start_controls_section(
			'section_cryptocurrency_image_style',
			[
				'label' => __( 'Logo', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'show_currency_image' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			'currency_logo_image_width',
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
					'{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-image img' => 'width: {{SIZE}}{{UNIT}};margin-left: auto;margin-right: auto;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cryptocurrency_name_style',
			[
				'label' => __( 'Currency Name', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'cryptocurrency_name_color',
			[
				'label' => __( 'Name Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-name span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-name span',
			]
		);

		$this->add_control(
		'cryptocurrency_short_name_color',
			[
				'label' => __( 'Short Name Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-short-name span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'short_name_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-short-name span',
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
                    '{{WRAPPER}} .avt-crypto-currency-card .avt-currency .avt-currency-name' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		
		$this->start_controls_section(
			'section_cryptocurrency_current_price_style',
			[
				'label' => __( 'Currency Price', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'cryptocurrency_current_price_color',
			[
				'label' => __( 'Primary Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-current-price .avt-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'cryptocurrency_price_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-current-price .avt-price',
			]
		);

		$this->add_control(
		'cryptocurrency_percentage_color',
			[
				'label' => __( 'Secondary Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-current-price .avt-percentage' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'cryptocurrency_percentage_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-current-price .avt-percentage',
			]
		);

		$this->end_controls_section();

		

		$this->start_controls_section(
			'section_cryptocurrency_text_style',
			[
				'label' => __( 'Currency List', 'avator-widget-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'cryptocurrency_text_primary_color',
			[
				'label' => __( 'Primary Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
		'cryptocurrency_text_secondary_color',
			[
				'label' => __( 'Secondary Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute .avt-item-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
		Group_Control_Typography::get_type(),
			[
				'name' => 'cryptocurrency_text_typography',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute span',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cryptocurrency_card_text_item_border',
				'selector' => '{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute',
			]
		);

		$this->add_control(
			'crypto_currency_card_test_item_border_color',
			[
				'label' => __( 'Border Color', 'avator-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'cryptocurrency_text_padding',
			[
				'label' => __( 'Padding', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'cryptocurrency_text_margin',
			[
				'label' => __( 'Margin', 'avator-widget-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .avt-crypto-currency-card .avt-ccc-atribute span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		        'order'       => false, //market_cap_desc
		        'per_page'    => 1, //limit
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
		
		$saved_coins = get_transient( 'widget-pack-ccc' );

		if (false == $saved_coins) {
			set_transient( 'widget-pack-ccc', $coins, 5 * MINUTE_IN_SECONDS );
			$coins = get_transient( 'widget-pack-ccc' );
		}

		return $coins;

	}

	protected function render() {
		$settings        = $this->get_settings();
		$id              = $this->get_id();
		$coins           = $this->render_coin_api();
		$currency        = $settings['currency'];
		$currency_symbol = widget_pack_currency_symbol($settings['currency']);
		$crypto_currency = ($settings['crypto_currency']) ? $settings['crypto_currency'] : false;
		$locale          = explode('-', get_bloginfo('language'));
		$locale          = $locale[0];
	   	
		?>
		<div class="avt-crypto-currency-card">
			<div avt-grid>

				<?php foreach($coins as $coin) : ?>

				<div class="avt-width-1-1 avt-width-1-2@s">
					<div class="avt-currency">

						<?php if ($settings['show_currency_image']) : ?>
    					<div class="avt-currency-image">
    						<img src="<?php echo esc_url($coin['image']); ?>"/>
    					</div>
    					<?php endif; ?>

    					<?php if ($settings['show_currency_name']) : ?>
    					<div class="avt-currency-name">
    						<span><?php echo esc_html( $coin['name'] ); ?></span>
    					</div>
    					<?php endif; ?>

    					<?php if ($settings['show_currency_short_name']) : ?>
    					<div class="avt-currency-short-name">
    						<span><?php echo esc_attr( $coin['symbol'] ); ?> / <?php echo esc_html( $currency ); ?></span>
    					</div>
    					<?php endif; ?>

					</div>
				</div>

				<div class="avt-width-1-1 avt-width-1-2@s">
					<div class="avt-current-price">

						<?php if ($settings['show_currency_current_price']) : ?>
						<div class="avt-price">
							<?php echo esc_html( $currency_symbol ); ?><?php echo widget_pack_money_format($coin['current_price']); ?>
						</div>
						<?php endif; ?>

						<?php if ($settings['show_currency_change_price']) : ?>
						<div class="avt-percentage">(<?php echo widget_pack_money_format($coin['price_change_24h']) ; ?>%)</div>
						<?php endif; ?>

					</div>
				</div>

				<div class="avt-width-1-1 avt-margin-small-top avt-ccc-atributes">

					<div class="avt-ccc-atribute">
						<?php if ($settings['show_currency_marketing_rank']) : ?>
						<span class="avt-item-text"><?php esc_html_e('Market Cap Rank: ', 'avator-widget-pack'); ?></span>
						<span>#<?php echo esc_html($coin['market_cap_rank']); ?></span>
						<?php endif; ?>
					</div>

					<div class="avt-ccc-atribute">
						<?php if ($settings['show_currency_market_cap']) : ?>
						<span class="avt-item-text"><?php esc_html_e('Market Cap: ', 'avator-widget-pack'); ?></span>
						<span><?php echo esc_html( $currency_symbol ); ?><?php echo esc_html($coin['market_cap']); ?></span>
						<?php endif; ?>
					</div>

					<div class="avt-ccc-atribute">
						<?php if ($settings['show_currency_total_volume']) : ?>
						<span class="avt-item-text"><?php esc_html_e('24H Volume: ', 'avator-widget-pack'); ?></span>
						<span><?php echo esc_html( $currency_symbol ); ?><?php echo esc_html($coin['total_volume']); ?></span>
						<?php endif; ?>
					</div>

					<div class="avt-ccc-atribute">
						<?php if ($settings['show_currency_high_low']) : ?>
						<span class="avt-item-text"><?php esc_html_e('24H High/Low: ', 'avator-widget-pack'); ?></span>
						<span><?php echo esc_html( $currency_symbol ); ?><?php echo esc_html($coin['high_24h']); ?>/<?php echo esc_html( $currency_symbol ); ?><?php echo esc_html($coin['low_24h']); ?></span>
						<?php endif; ?>
					</div>

				</div>

				<?php endforeach; ?>

			</div>
		</div>
     
		<?php
	}
}

