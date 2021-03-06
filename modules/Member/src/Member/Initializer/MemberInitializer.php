<?php

namespace Member\Initializer;

use Member\Controller\MemberController;

class MemberInitializer {

	const VALIDATE_SLUG = 'validate-account';

	private $memberController;
	
	function __construct() {
		$this->memberController = new MemberController();
		add_action('wp_loaded', array(&$this, 'initializePlugin'), 1);
		add_action('init', array(&$this, 'createValidateAccountPage'));

		add_shortcode('gfsn-validate-account', array(&$this, 'addValidateAccountPage'));
		add_shortcode('gfsn-subscribe-member', array(&$this, 'addSubscribeMember'));
		add_shortcode('gfsn-login', array(&$this, 'addLoginPage')); 
		add_shortcode('gfsn-join-button', array(&$this, 'joinButton')); 

		add_filter('wp_mail_content_type', array(&$this, 'setEmailsAsHtml'));
		add_action('wp_print_scripts', array(&$this, 'removePasswordStrenght'), 100);
		add_filter('user_contactmethods', array(&$this, 'isUserValidatedHeader'), 10, 1);
		add_filter('manage_users_columns', array(&$this, 'addUserValidatedColumn'));
		add_filter('manage_users_custom_column', array(&$this, 'addUserValidatedRow'), 10, 3);

		add_action('show_user_profile', array(&$this, 'showDownloadedProducts'), 50);
		add_action('edit_user_profile', array(&$this, 'showDownloadedProducts'), 50);
		add_action('send_first_reminder_email', array(&$this, 'sendFirstReminderEmail'), 10, 1);
		add_action('send_second_reminder_email', array(&$this, 'sendSecondReminderEmail'), 10, 1);

		add_action('widgets_init', array(&$this, 'registerFooterWidget'));
		
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

		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership/share-resource', array(
				'methods' => 'POST',
				'callback' => array(&$this->memberController, 'sendEmailsForSharing'),
			));
		});

		add_action('rest_api_init', function() {
			register_rest_route( 'gfsn-api', '/membership/track-resource', array(
				'methods' => 'POST',
				'callback' => array(&$this->memberController, 'trackDownloads'),
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

	public function showDownloadedProducts($user) {
		include __DIR__ . '/../views/downloaded_products.php';
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

	public function sendFirstReminderEmail($user) {
		$this->memberController->sendFirstConfirmationReminderEmail($user);
	}

	public function sendSecondReminderEmail($user) {
		$this->memberController->sendSecondConfirmationReminderEmail($user);
	}

	public function registerFooterWidget() {
		register_widget('Member\\Widget\\FooterWidget');
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

	public function createValidateAccountPage() {
		$args = array(
		  'name'        => self::VALIDATE_SLUG,
		  'post_type'   => 'page',
		  'post_status' => 'publish',
		  'numberposts' => 1
		);
		$posts = get_posts($args);
		if (!$posts) {
			$page = array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	1,
				'post_name'		=>	'validate-account',
				'post_title'		=>	'Complete Your Registration',
				'post_status'		=>	'publish',
				'post_content'	=> '[gfsn-validate-account]',
				'post_type'		=>	'page'
			);
			wp_insert_post($page);
		}
	}

	public function addValidateAccountPage() {
		ob_start();
		include __DIR__ . '/../views/validate_account.php';
		return ob_get_clean();
	}

	public function joinButton() {
		ob_start();
		include __DIR__ . '/../views/join_button.php';
		return ob_get_clean();
	}

	public function addSubscribeMember() {
		ob_start();
		include __DIR__ . '/../views/subscribe_member.php';
		return ob_get_clean();
	}

	public function addLoginPage() {
		ob_start();
		include __DIR__ . '/../views/login.php';
		return ob_get_clean();
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
		//wp_enqueue_script('gfsn-mail', plugin_dir_url( __FILE__ ) . '../scripts/email.js');
		wp_enqueue_script('gfsn-member-service', plugin_dir_url( __FILE__ ) . '../scripts/MemberService.js');
		wp_enqueue_script('gfsn-member-controller', plugin_dir_url( __FILE__ ) . '../scripts/MemberController.js');
		$this->setAjaxNonce();
	}

	private function enqueStyles() {
		wp_enqueue_style('gsfn-main-styles', plugin_dir_url( __FILE__ ) . '../styles/main.css');
	}

}