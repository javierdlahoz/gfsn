<?php

namespace Author\Initializer;

use Author\Service\AuthorService;

class AuthorInitializer {

	private $authorService;

	function __construct() {
		$this->authorService = new AuthorService();
		add_action('woocommerce_product_tabs', array(&$this, 'addAuthorsInfo'), 30);
		add_action('init', array(&$this, 'addStyles'));
		add_action('widgets_init', array(&$this, 'registerAuthorsWidget'));
	}

	public function addStyles() {
		wp_enqueue_style('gfsn-authors', plugin_dir_url( __FILE__ ) . '../styles/authors.css');
	}

	public function addAuthorsInfo($tabs) {
		$tabs['authors_tab'] = array(
			'title' => __('Authors', 'woocommerce'),
			'priority' => 15,
			'callback' => array(&$this, 'authorsTab')
		);
		return $tabs;
	}

	public function authorsTab() {
		include __DIR__ . '/../views/authors_info.php';
	}

	public function registerAuthorsWidget() {
			register_widget('Author\\Widget\\AuthorsWidget');
	}

}