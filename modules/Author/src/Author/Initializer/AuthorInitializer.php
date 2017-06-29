<?php

namespace Author\Initializer;

use Author\Service\AuthorService;

class AuthorInitializer {

	private $authorService;

	function __construct() {
		$this->authorService = new AuthorService();
		add_action('admin_init', array(&$this, 'addAuthorToProduct'));
	}

	public function addAuthorToProduct() {
		add_meta_box('author_metabox', 'Author', array(&$this->authorService, 'getAuthorField'), 'product', 'side');
	}

}