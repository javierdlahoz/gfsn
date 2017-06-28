<?php

namespace Member\Controller;

use Member\Helper\MemberHelper;

class MemberController {

	const UNIQUE_TOKEN = 'unique_token';
	const VALIDATED = 'email_validated';
	const INITIAL_PASSWORD = 'initial_password';

	function __construct() {}

	public function nounce() {
		return array('nounce' => wp_create_nonce('wp_rest'));
	}

	public function subscribe() {
		$user = get_user_by('email', $_POST['email']);
		if ($user) {
			$validated = get_user_meta($user->ID, self::VALIDATED, true);
			return array('message' => 'Member already registered', 'validated' => $validated);
		}

		$password = wp_generate_password();
		$uniqueToken = uniqid();
		
		$user = wp_create_user($_POST['email'], $password, $_POST['email']);
	
		if ($user) {
			wp_new_user_notification($user, $password);

			update_user_meta($user, self::UNIQUE_TOKEN, $uniqueToken);
			update_user_meta($user, self::VALIDATED, false);
			update_user_meta($user, self::INITIAL_PASSWORD, $password);

			$this->sendConfirmEmail($_POST['email'], $uniqueToken);

			wp_signon(array('user_login' => $_POST['email'], 'user_password' => $password, 'remember' => true), false);
			return array('message' => 'Member successfully subscribed', 'validated' => false);
		}
		else {
			wp_send_json_error($user);
		}

	}

	public function files() {
		$productId = $_GET['product_id'];
		$product = wc_get_product($productId);
		$files = [];
		foreach ($product->get_downloads() as $download) {
			$files[] = $download->get_data()['file'];
		}
		return array('files' => $files);
	}

	public function login() {
		$user = wp_signon(array('user_login' => $_POST['email'], 'user_password' => $_POST['password'], 'remember' => true), false);
		if (!is_wp_error($user)) {
			return array('message' => 'Member successfully logged in', 'success' => true);
		} else {
			wp_send_json_error(array('message' => 'Wrong credentials'));
		}
	}

	public function isLoggedIn() {
		$cUser = wp_get_current_user();
		if ($cUser->ID > 0) {
			$validated = get_user_meta($cUser->ID, self::VALIDATED, true);
			return array('message' => 'Member already logged in', 'validated' => (bool) $validated, 'success' => true);
		} else {
			wp_send_json_error(array('message' => 'User not logged in'));
		}
	}

	private function getMembershipPlanId() {
		$plans = wc_memberships_get_membership_plans();
		if ($plans) {
			return $plans[0]->id;
		}
		return null;
	}

	private function assignPlanToUser($userId) {
		$planId = $this->getMembershipPlanId();
		if ($planId) {
			$args = array(
        'plan_id'	=> $this->getMembershipPlanId(),
        'user_id'	=> $userId,
	    );
	    wc_memberships_create_user_membership( $args );
		}
	}

	private function sendConfirmEmail($email, $token) {
		$headers = 'From: info <'.get_option('admin_email').'>';
		$to = $email;
		$subject = get_option('blogname').' Confirm your email';
		$message = '<h2>Thank you for subscribe.</h2><br> Please click on <a href="'.home_url('/').'?email_token='.$token.'">confirm</a> to continue';
		MemberHelper::send($to, $subject, $message, $headers);		
	}
}
