<?php
namespace WidgetPack\Base;
use Elementor\Core\Base\Module;
use WidgetPack\Widget_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

abstract class Widget_Pack_Module_Base extends Module {

    public function get_widgets() {
        return [];
    }

    public function __construct() {
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }

    public function init_widgets() {

        $widget_manager = Widget_Pack_Loader::elementor()->widgets_manager;

        foreach ( $this->get_widgets() as $widget ) {
            $class_name = $this->get_reflection()->getNamespaceName() . '\Widgets\\' . $widget;
            $widget_manager->register_widget_type( new $class_name() );
        }
    }
}