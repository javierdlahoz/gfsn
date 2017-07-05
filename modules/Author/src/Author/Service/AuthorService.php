<?php

namespace Author\Service;

class AuthorService {

	const AUTHOR_IDS = 'post-option';
	const AUTHOR_SLUG = 'team';

  /**
   * @param  int $postId
   * @return array
   */
  public static function getAuthorsFromPost($postId) {
    $authors = array();
    $options = json_decode(get_post_meta($postId, self::AUTHOR_IDS, true));
    foreach ($options->{'select-author'} as $id) {
      $authors[] = get_post($id);
    }
    return $authors;
  }

  public static function getProductsByAuthor($authorId) {
    $args = array(
      'post_type' => 'product',
      'meta_query' => array(
        array(
          'key' => self::AUTHOR_IDS,
          'value' => '"'.$authorId.'"',
          'compare' => 'LIKE',
        )
      )
    );
    $products = get_posts($args);
    return $products;
  }

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

  public static function getTeamBgHeader($teamId) {
    $options = json_decode(get_post_meta($teamId, self::AUTHOR_IDS, true));
    if(isset($options->{'header-background'})) {
      return wp_get_attachment_url($options->{'header-background'});
    } else {
      return null;
    }
  }

}