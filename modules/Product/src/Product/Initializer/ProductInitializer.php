<?php

namespace Product\Initializer;

use Product\Widget\CategoryWidget;

class ProductInitializer {

    function __construct() {
        $this->enqueStyles();
        add_action('widgets_init', array(&$this, 'registerCategoriesWidget'));
        add_shortcode('gfsn-about-section', array(&$this, 'aboutSection'));
    }

    public function registerCategoriesWidget() {
        register_widget('Product\\Widget\\CategoryWidget');
    }

    public function aboutSection() {
        include_once __DIR__. '/../views/about_section.php';
    }

    private function enqueStyles() {
		wp_enqueue_style('gsfn-about-styles', plugin_dir_url( __FILE__ ) . '../styles/about.css');
	}
}