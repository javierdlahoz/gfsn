<?php

namespace Member\Initializer;

use Member\Controller\MemberController;

class MemberInitializer {

	private $memberController;
	
	function __construct() {
		$this->memberController = new MemberController();
		add_action('wp_loaded', array(&$this, 'initializePlugin'));
		add_filter('wp_mail_content_type', array(&$this, 'setEmailsAsHtml'));
		add_action('wp_print_scripts', array(&$this, 'removePasswordStrenght'), 100);
		add_filter('user_contactmethods', array(&$this, 'isUserValidatedHeader'), 10, 1);
		add_filter('manage_users_columns', array(&$this, 'addUserValidatedColumn'));
		add_filter('manage_users_custom_column', array(&$this, 'addUserValidatedRow'), 10, 3);
		
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
			register_rest_route( 'gfsn-api', '/membership/resend-email', array(
				'methods' => 'GET',
				'callback' => array(&$this->memberController, 'resendEmail'),
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

	public function removePasswordStrenght() {
		if (wp_script_is( 'wc-password-strength-meter', 'enqueued')) {
			wp_dequeue_script('wc-password-strength-meter');
		}
	}

	public function isUserValidatedHeader($contactmethods) {
		$contactmethods['validated'] = 'Validated';
		return $contactmethods;
	}

	public function addUserValidatedColumn($column) {
		$column['validated'] = 'Validated';
		return $column;
	}

	public function addUserValidatedRow($val, $column, $userId) {
		switch ($column) {
			case 'validated':
				$validated = $this->memberController->isUserValidated($userId);
				if ($validated) {
					return 'yes';
				} else {
					return 'no';
				}
				break;
			default:
				return $val;
				break;
		}
		return $val;
	}

	private function setAjaxNonce() {
		$params = array(
		  'nonce' => wp_create_nonce('wp_rest')
		);
		wp_localize_script('gfsn-member-service', 'ajaxObject', $params);
	}

	private function enqueScripts() {
		wp_enqueue_script('angularjs', plugin_dir_url( __FILE__ ) . '../scripts/angular.min.js');
		wp_enqueue_script('gfsn-main', plugin_dir_url( __FILE__ ) . '../scripts/main.js');
		wp_enqueue_script('gfsn-mail', plugin_dir_url( __FILE__ ) . '../scripts/email.js');
		wp_enqueue_script('gfsn-member-service', plugin_dir_url( __FILE__ ) . '../scripts/MemberService.js');
		wp_enqueue_script('gfsn-member-controller', plugin_dir_url( __FILE__ ) . '../scripts/MemberController.js');
		$this->setAjaxNonce();
	}

	private function enqueStyles() {
		wp_enqueue_style('gsfn-main-styles', plugin_dir_url( __FILE__ ) . '../styles/main.css');
	}

}