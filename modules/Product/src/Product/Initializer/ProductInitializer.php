<?php

namespace Product\Initializer;

use Product\Widget\CategoryWidget;

class ProductInitializer {

    function __construct() {
        add_action('widgets_init', array(&$this, 'registerCategoriesWidget'));
    }

    public function registerCategoriesWidget() {
        register_widget('Product\\Widget\\CategoryWidget');
    }
}