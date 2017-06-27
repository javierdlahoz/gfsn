<?php

namespace Member\Initializer;

use Member\Controller\MemberController;

class MemberInitializer {

	private $memberController;
	
	function __construct() {
		$this->memberController = new MemberController();
		add_action('wp_loaded', array(&$this, 'initializePlugin'));
		add_filter('wp_mail_content_type', array(&$this, 'setEmailsAsHtml'));
		
		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership', array(
				'methods' => 'POST',
				'callback' => array(&$this->memberController, 'subscribe'),
			));
		});

		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership/logged-in', array(
				'methods' => 'GET',
				'callback' => array(&$this->memberController, 'isLoggedIn'),
			));
		});

		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership/files', array(
				'methods' => 'GET',
				'callback' => array(&$this->memberController, 'files'),
			));
		});

		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership/login', array(
				'methods' => 'POST',
				'callback' => array(&$this->memberController, 'login'),
			));
		});

		add_action('woocommerce_single_product_summary', array(&$this, 'addDownloadButton'), 30);
	}

	public function initializePlugin() {
		$this->enqueScripts();
		$this->enqueStyles();
	}

	public function addDownloadButton() {
		include __DIR__ . '/../views/download_button.php';
	}

	public function setEmailsAsHtml() {
		return 'text/html';
	}

	private function enqueScripts() {
		wp_enqueue_script('gfsn-main', plugin_dir_url( __FILE__ ) . '../scripts/main.js');
		wp_localize_script(
        'popup-js',
        'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    ); 
	}

	private function enqueStyles() {
		wp_enqueue_style('gsfn-main-styles', plugin_dir_url( __FILE__ ) . '../styles/main.css');
	}

}