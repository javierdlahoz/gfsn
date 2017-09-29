<?php

namespace Product\Initializer;

use Product\Widget\CategoryWidget;

class ProductInitializer {

    function __construct() {

        $this->enqueStyles();
        add_action('wp_loaded', array(&$this, 'enqueScripts'), 99);
        //$this->enqueScripts();

        add_action('widgets_init', array(&$this, 'registerCategoriesWidget'));
        add_shortcode('gfsn-about-section', array(&$this, 'aboutSection'));

        add_filter('woocommerce_product_tabs', array(&$this, 'removeTabs'), 20);
        add_action('woocommerce_single_product_summary', array(&$this, 'addProductDetails'), 31);
        add_action('woocommerce_single_product_summary', array(&$this, 'addShareProduct'), 51);
        // add_action('woocommerce_single_product_summary', array(&$this, 'addProductDescription'), 51);
    }

    public function enqueScripts() {
        wp_enqueue_script('gfsn-products', \plugin_dir_url(__FILE__) . '../scripts/products.js');
        wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/ace78da580.js');
	}

    private function enqueStyles() {
		wp_enqueue_style('gsfn-about-styles', plugin_dir_url( __FILE__ ) . '../styles/about.css');
        wp_enqueue_style('gsfn-products-styles', plugin_dir_url( __FILE__ ) . '../styles/products.css');
	}

    public function registerCategoriesWidget() {
        register_widget('Product\\Widget\\CategoryWidget');
    }

    public function aboutSection() {
        include_once __DIR__. '/../views/about_section.php';
    }

    public function addProductDescription() {
        include __DIR__ . '/../views/product_description.php';
    }

    public function addProductDetails() {
        include __DIR__ . '/../views/product_details.php';
    }

    public function addShareProduct() {
        include __DIR__ . '/../views/share.php';
    }

    public function removeTabs($tabs) {
        unset($tabs['reviews']);
        return $tabs;
    }
}