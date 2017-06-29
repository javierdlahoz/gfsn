<?php

namespace Author\Initializer;

use Author\Service\AuthorService;

class AuthorInitializer {

	private $authorService;

	function __construct() {
		$this->authorService = new AuthorService();
		add_action('admin_init', array(&$this, 'addAuthorToProduct'));
		add_action('save_post', array(&$this->authorService, 'saveAuthorsOnProducts'));
	}

	public function addAuthorToProduct() {
		add_meta_box('author_metabox', 'Authors', array(&$this->authorService, 'getAuthorField'), 'product', 'side');
	}

}