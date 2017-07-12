<?php 

namespace Author\Widget;

class AuthorsWidget extends \WP_Widget {

	const AUTHORS_WIDGET_ID = 'gfsn_authors_widget';
	const AUTHORS_WIDGET_DOMAIN = 'gfsn_widget_domain';

    function __construct() {
        parent::__construct(self::AUTHORS_WIDGET_ID, 
            __('GFSN Authors Widget', self::AUTHORS_WIDGET_DOMAIN),
            array( 'description' => __( 'Authors widget', self::AUTHORS_WIDGET_DOMAIN)));
    }

	public function widget($args, $instance) {
		include_once __DIR__ . '/../views/authors_widget.php';
	}

}