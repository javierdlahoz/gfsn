<?php

/**
 * Plugin Name: Great Free Stuffs for Non-profit Plugin
 * Plugin URI: https://local.gfsn.com/
 * Description: Custom build
 * Version: 1.1
 * Author: GFSN
 * Requires at least: 4.4
 * Tested up to: 4.8
 *
 */

require __DIR__ . '/config/autoloader.php';

use Member\Initializer\MemberInitializer;
use Member\Controller\MemberController;

if ( ! class_exists( 'Gfsn' ) ) :

class Gfsn {

	function __construct() {
		$initializer = new MemberInitializer();
		if (isset($_GET['email_token'])) {
			add_action('init', array(&$this, 'validateToken'));
		}
	}

	public function validateToken() {
		$token = $_GET['email_token'];
		$users = get_users(array('meta_key' => MemberController::UNIQUE_TOKEN, 'meta_value' => $token));
		if ($users && $users[0]) {
			$user = $users[0];
			update_user_meta($user->ID, MemberController::VALIDATED, true);
			$password = get_user_meta($user->ID, MemberController::INITIAL_PASSWORD, true);
			$auth = wp_signon(array('user_login' => $user->user_login, 'user_password' => $password, 'remember' => true), false);
			if (!is_wp_error($auth)) {
				wp_redirect(home_url('/my-account/edit-account/'));
				exit();
			}
		}
	}

}

$gfsn = new Gfsn();
endif;