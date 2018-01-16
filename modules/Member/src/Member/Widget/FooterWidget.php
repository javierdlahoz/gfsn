<?php

namespace Member\Widget;

class FooterWidget extends \WP_Widget {

    const FOOTER_WIDGET_ID = 'npl_footer_widget';
	const FOOTER_WIDGET_DOMAIN = 'npl_widget_domain';

    function __construct() {
        parent::__construct(self::FOOTER_WIDGET_ID, 
            __('NPL Footer Widget', self::FOOTER_WIDGET_DOMAIN),
            array( 'description' => __( 'Sample widget for NPL Footer', self::FOOTER_WIDGET_DOMAIN)));
    }

	public function widget($args, $instance) {
		include_once __DIR__ . '/../views/footer.php';
	}
}