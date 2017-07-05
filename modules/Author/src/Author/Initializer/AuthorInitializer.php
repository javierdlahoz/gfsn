<?php

namespace Author\Initializer;

use Author\Service\AuthorService;

class AuthorInitializer {

	private $authorService;

	function __construct() {
		$this->authorService = new AuthorService();
		//add_action('admin_init', array(&$this, 'addAuthorToProduct'));
		//add_action('save_post', array(&$this->authorService, 'saveAuthorsOnProducts'));
		add_action('woocommerce_product_tabs', array(&$this, 'addAuthorsInfo'), 30);
		add_action('init', array(&$this, 'addStyles'));
		//add_action('init', array(&$this, 'createAuthorPostType'));
	}

	public function addStyles() {
		wp_enqueue_style('gfsn-authors', plugin_dir_url( __FILE__ ) . '../styles/authors.css');
	}

	public function addAuthorToProduct() {
		add_meta_box('author_metabox', 'Authors', array(&$this->authorService, 'getAuthorField'), 'product', 'side');
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

	public function createAuthorPostType() {
		$labels = array(
	    'name'               => __( 'Authors' ),
	    'singular_name'      => __( 'Author' ),
	    'add_new'            => _x( 'Add New', 'Author' ),
	    'add_new_item'       => __( 'Add New Author' ),
	    'edit_item'          => __( 'Edit Author' ),
	    'new_item'           => __( 'New Author' ),
	    'all_items'          => __( 'All Authors' ),
	    'view_item'          => __( 'View Author' ),
	    'search_items'       => __( 'Search authors' ),
	    'not_found'          => __( 'No authors found' ),
	    'not_found_in_trash' => __( 'No authors found in the Trash' ),
	    'parent_item_colon'  => '',
	    'menu_name'          => 'Authors'
	  );

	  $args = array(
	    'labels'        => $labels,
	    'public'        => true,
	    'menu_position' => 7,
	    'show_ui'       => true,
	    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	    'has_archive' 	=> true,
	    'rewrite' 			=> array('slug' => 'authors'),
	    'capability_type' => 'post'
	  );

	  register_post_type( AuthorService::AUTHOR_SLUG, $args );

	  flush_rewrite_rules();
	  $set = get_option('post_type_rules_flased_author');
		if ($set !== true){
		    flush_rewrite_rules(false);
		    update_option('post_type_rules_flased_author', true);
		}
	}

}