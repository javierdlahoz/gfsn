<?php

namespace Slider\Initializer;

class SliderInitializer {

    function __construct() {
        $this->enqueStyles();
        add_shortcode('gfsn-slider', array(&$this, 'slider'));
    }

		public function slider($args) {
			$sliders = \Slider\Service\SliderService::getSlidesByTag($args['tag']);
			include_once __DIR__. '/../views/slider.php';
		}

    private function enqueStyles() {
			wp_enqueue_style('gsfn-slider-styles', plugin_dir_url( __FILE__ ) . '../styles/slider.css');
		}
}