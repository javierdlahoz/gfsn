<?php

namespace Author\Service;

class AuthorService {

	const AUTHOR_IDS = 'author_ids';
	const AUTHOR_SLUG = 'book_author';

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

}