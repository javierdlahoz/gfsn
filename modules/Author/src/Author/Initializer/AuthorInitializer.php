<?php

namespace Author\Initializer;

use Author\Service\AuthorService;

class AuthorInitializer {

	private $authorService;

	function __construct() {
		$this->authorService = new AuthorService();
		add_action('admin_init', array(&$this, 'addAuthorToProduct'));
		add_action('save_post', array(&$this->authorService, 'saveAuthorsOnProducts'));
		add_action('woocommerce_single_product_summary', array(&$this, 'addAuthorsInfo'), 30);
		add_action('init', array(&$this, 'addStyles'));
	}

	public function addStyles() {
		wp_enqueue_style('gfsn-authors', plugin_dir_url( __FILE__ ) . '../styles/authors.css');
	}

	public function addAuthorToProduct() {
		add_meta_box('author_metabox', 'Authors', array(&$this->authorService, 'getAuthorField'), 'product', 'side');
	}

	public function addAuthorsInfo() {
		include __DIR__ . '/../views/authors_info.php';
	}

}