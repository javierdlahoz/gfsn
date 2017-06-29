<?php

namespace Author\Service;

class AuthorService {

	const AUTHOR_IDS = 'author_ids';
	const AUTHOR_SLUG = 'author';

	public function getAuthorField() {
		global $post;
    $authorIds = get_post_meta($post->ID, self::AUTHOR_IDS, true);
    $authors = get_posts(array(
        'post_type' => self::AUTHOR_SLUG,
        'numberposts' => -1,
        'orderby' => 'post_title',
        'order' => 'ASC'
    ));
    include __DIR__ . '/../views/author_field.php';
	}

	public function saveAuthorsOnProducts($productId) {
		if ('product' != get_post_type($productId))
      return $productId;        
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return $productId;
		if (!current_user_can('edit_post', $productId))
      return $productId;
    
    update_post_meta($productId, self::AUTHOR_IDS, $_POST[self::AUTHOR_IDS]);
	}

}