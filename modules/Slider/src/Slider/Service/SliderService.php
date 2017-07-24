<?php

namespace Slider\Service;

class SliderService {

	const SLIDER_TYPE = 'slider';

	/**
	 *
	 * @param string $tag
	 * @return multitype: WP_Post
	 */
	public static function getSlidesByTag($tag) {
		$args = array(
			'posts_per_page' => -1, 
			'tag' => $tag,
			'post_type' => self::SLIDER_TYPE
		);
		$sliders = get_posts($args);
		return $sliders;
	}

}