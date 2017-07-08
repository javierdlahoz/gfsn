<?php

namespace Product\Widget;

class CategoryWidget extends \WP_Widget {

    const CATEGORY_WIDGET_ID = 'gfsn_cat_widget';
	const CATEGORY_WIDGET_DOMAIN = 'gfsn_widget_domain';

    function __construct() {
        parent::__construct(self::CATEGORY_WIDGET_ID, 
            __('GFSN Categories Widget', self::CATEGORY_WIDGET_DOMAIN),
            array( 'description' => __( 'Sample widget to show Products categories', self::CATEGORY_WIDGET_DOMAIN)));
    }

	public function widget($args, $instance) {
		include_once __DIR__ . '/../views/categories.php';
	}
}