<?php
namespace WidgetPack\Modules\Qrcode\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Qrcode extends Widget_Base {

	public function get_name() {
		return 'avt-qrcode';
	}

	public function get_title() {
		return AWP . esc_html__( 'QR Code', 'avator-widget-pack' );
	}

	public function get_icon() {
		return 'avt-wi-qrcode';
	}

	public function get_categories() {
		return [ 'widget-pack' ];
	}

	public function get_keywords() {
		return [ 'qr', 'code' ];
	}

	public function get_style_depends() {
		return [ 'wipa-qrcode' ];
	}

	public function get_script_depends() {
		return [ 'qrcode', 'wipa-qrcode' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/3ofLAjpnmO8';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_qrcode',
			[
				'label' => esc_html__( 'QR Code', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Content', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'http://avator.com',
				'default'     => 'http://avator.com',
				'condition'   => ['site_link!' => 'yes'],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'site_link',
			[
				'label' => esc_html__( 'This Page Link', 'avator-widget-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'label_type',
			[
				'label'   => esc_html__( 'Label Type', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'none'  => esc_html__( 'None', 'avator-widget-pack' ),
					'text'  => esc_html__( 'Text', 'avator-widget-pack' ),
					'image' => esc_html__( 'Image', 'avator-widget-pack' ),
				]
			]
		);

		$this->add_control(
			'label',
			[
				'label'       => esc_html__( 'Text', 'avator-widget-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'AVATOR',
				'default'     => 'AVATOR',
				'condition'   => [
					'label_type' => 'text',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => __( 'Choose Image', 'avator-widget-pack' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'label_type' => 'image',
				],
				'default' => [
					'url' => AWP_ASSETS_URL.'images/no-image.jpg',
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'mode',
			[
				'label'   => esc_html__( 'Mode', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 2,
				'options' => [
					1 => esc_html__( 'Strip', 'avator-widget-pack' ),
					2 => esc_html__( 'Box', 'avator-widget-pack' ),
				],
				'condition'   => [
					'label_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'avator-widget-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'avator-widget-pack' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default'      => 'center',
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_qr_code_additional',
			[
				'label' => esc_html__( 'Additional', 'avator-widget-pack' ),
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => esc_html__( 'Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 50,
					],
				],
			]
		);

		$this->add_control(
			'mSize',
			[
				'label'   => esc_html__( 'Label Size', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 11,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 40,
						'step' => 1,
					],
				],
				'condition' => [
					'label_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'mPosX',
			[
				'label'   => esc_html__( 'Label POS X:', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'label_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'mPosY',
			[
				'label'   => esc_html__( 'Label POS Y:', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'label_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'minVersion',
			[
				'label'   => esc_html__( 'Min Version', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 6,
				],
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'ecLevel',
			[
				'label'   => esc_html__( 'Error Correction Level', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'H',
				'options' => [
					'L' => esc_html__( 'Low (7%)', 'avator-widget-pack' ),
					'M' => esc_html__( 'Medium (15%)', 'avator-widget-pack' ),
					'Q' => esc_html__( 'Quartile (25%)', 'avator-widget-pack' ),
					'H' => esc_html__( 'High (30%)', 'avator-widget-pack' ),
				],
			]
		);

		$this->end_controls_section();		

		$this->start_controls_section(
			'section_style_qrcode',
			[
				'label' => esc_html__( 'QR Code', 'avator-widget-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'fill',
			[
				'label'   => esc_html__( 'Code Color', 'avator-widget-pack' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#333333',
			]
		);

		$this->add_control(
			'fontcolor',
			[
				'label'     => esc_html__( 'Label Color', 'avator-widget-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff9818',
				'condition' => [
					'label_type' => 'text',
				],
			]
		);

		$this->add_control(
			'radius',
			[
				'label'   => esc_html__( 'Code Radius', 'avator-widget-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 10,
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$id         = 'avt-qrcode' . $this->get_id();
		$image_src  = wp_get_attachment_image_src( $settings['image']['id'], 'full' );
		$image      = ($image_src) ? $image_src[0] : AWP_ASSETS_URL.'images/no-image.jpg';
		$qr_content = $settings['text'];
		
		if ($settings['site_link']) {
			$qr_content =  get_permalink();
		}

		 if( 'none' == $settings['label_type'] ){
			$mode = 0;
		 } elseif( 'text' == $settings['label_type'] ){
		 	$mode = $settings['mode'];
		 } elseif( '' != $settings['image'] ){
		 	 $mode = $settings['mode'] + 2;
		 } else {
		 	$mode = 0;
		 }

		 $this->add_render_attribute(
		 	[
		 		'qrcode' => [
		 			'data-settings' => [
		 				wp_json_encode(array_filter([
		 					"render"     => "canvas",
		 					"ecLevel"    => $settings["ecLevel"],
		 					"minVersion" => $settings["minVersion"]["size"],
		 					"fill"       => $settings["fill"],
		 					"text"       => $qr_content,
		 					"size"       => $settings["size"]["size"],
		 					"radius"     => $settings["radius"]["size"] * 0.01,
		 					"mode"       => $mode,
		 					"mSize"      => $settings["mSize"]["size"] * 0.01,
		 					"mPosX"      => $settings["mPosX"]["size"] * 0.01,
		 					"mPosY"      => $settings["mPosY"]["size"] * 0.01,
		 					"label"      => $settings["label"],
		 					"fontcolor"  => $settings["fontcolor"],
		 		        ]))
		 			]
		 		]
		 	]
		 );

		?>
		<div class="avt-qrcode" <?php echo $this->get_render_attribute_string( 'qrcode' ); ?>></div>

		<?php if ('image' === $settings['label_type'] and !empty($image)) : ?>
			<img src="<?php echo esc_url($image); ?>" class="avt-hidden avt-qrcode-image" alt="<?php echo esc_html($settings["label"]); ?>">
		<?php endif;
    }

    protected function backup_content_template() {
    	?>
    	<#
			

			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			var $mode = 0;
			 if( 'none' == settings.label_type ) {
				$mode      = 0;
			 } else if( 'text' == settings.label_type ){
			 	$mode      = settings.mode;
			 } else if( '' != settings.image ) {
			 	 $mode      = settings.mode + 2;
			 } else {
			 	$mode = 0;
			 }

			view.addRenderAttribute( 'qrcode', 'data-eclevel', settings.ecLevel );

			view.addRenderAttribute( 'qrcode', 'data-minversion', settings.minVersion.size );
			view.addRenderAttribute( 'qrcode', 'data-fill', settings.fill );
			view.addRenderAttribute( 'qrcode', 'data-text', settings.text );
			view.addRenderAttribute( 'qrcode', 'data-size', settings.size.size );
			view.addRenderAttribute( 'qrcode', 'data-radius', settings.radius.size * 0.01 );					
			view.addRenderAttribute( 'qrcode', 'data-mode', $mode );
			view.addRenderAttribute( 'qrcode', 'data-msize', settings.mSize.size * 0.01 );
			view.addRenderAttribute( 'qrcode', 'data-mposx', settings.mPosX.size * 0.01 );
			view.addRenderAttribute( 'qrcode', 'data-mposy', settings.mPosY.size * 0.01 );					
			view.addRenderAttribute( 'qrcode', 'data-label', settings.label );
			view.addRenderAttribute( 'qrcode', 'data-fontcolor', settings.fontcolor );
		#>

		<div class="avt-qrcode" <# print( view.getRenderAttributeString( 'qrcode' ) ); #>></div>

		<# if ('image' === settings.label_type && image_url) { #>
			<img src="{{image_url}}" class="avt-hidden avt-qrcode-image" alt="">
		<# } #>


    	<?php 
    }
}