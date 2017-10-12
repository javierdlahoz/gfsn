<?php

namespace Member\Controller;

use Member\Helper\MemberHelper;

class MemberController
{

    const UNIQUE_TOKEN = 'unique_token';
    const VALIDATED = 'email_validated';
    const INITIAL_PASSWORD = 'initial_password';
    const REDIRECT_URL = 'gfsn-redirect-url';


    function __construct()
    {
    }

    public static function updateCurrentUser()
    {
        $wpPath = __DIR__ . '/../../../../../../../../wp-load.php';
        require_once($wpPath);
        $user = \wp_get_current_user();
        wp_update_user(array('ID' => $user->ID, 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name']));

        if (!empty($_POST['password'])) {
            wp_set_password($_POST['password'], $user->ID);
            wp_set_auth_cookie($user->ID);
            wp_set_current_user($user->ID);
            do_action('wp_login', $user->user_login, $user);
        }
        $url = get_user_meta($user->ID, self::REDIRECT_URL, true);
        if (strpos($url, '/product/')) {
            wp_redirect($url . '?subscribe=yes');
            return;
        }
        wp_redirect('/library' . '?subscribe=yes');
    }

    public function nounce()
    {
        return array('nounce' => wp_create_nonce('wp_rest'));
    }

    public function subscribe()
    {
        $user = get_user_by('email', $_POST['email']);
        if ($user) {
            $validated = $this->isUserValidated($user->ID);
            wp_send_json_error(array('message' => 'Member already registered', 'validated' => $validated));
        }

        $password = wp_generate_password(6);
        $uniqueToken = uniqid();

        $user = wp_create_user($_POST['email'], $password, $_POST['email']);
        // wp_update_user(array('ID' => $user, 'first_name' => $_POST['firstName'], 'last_name' => $_POST['lastName']));

        if ($user) {
            update_user_meta($user, self::UNIQUE_TOKEN, $uniqueToken);
            update_user_meta($user, self::VALIDATED, false);
            update_user_meta($user, self::INITIAL_PASSWORD, $password);
            update_user_meta($user, self::REDIRECT_URL, $_POST['redirectUrl']);

            $this->sendConfirmEmail($_POST['email'], $uniqueToken, $password);

            // wp_signon(array('user_login' => $_POST['email'], 'user_password' => $password, 'remember' => true), false);
            return array('message' => 'Member successfully subscribed', 'validated' => false, 'success' => true);
        } else {
            wp_send_json_error($user);
        }

    }

    public function files()
    {
        $productId = $_GET['product_id'];
        $product = wc_get_product($productId);
        $files = [];
        foreach ($product->get_downloads() as $download) {
            $files[] = $download->get_data()['file'];
        }
        return array('files' => $files);
    }

    public function login()
    {
        if (!username_exists($_POST['email'])) {
            wp_send_json_error(array('message' => "Sorry that email doesn't appear to exist please try again."));
        }
        $user = wp_signon(array('user_login' => $_POST['email'], 'user_password' => $_POST['password'], 'remember' => true), false);
        if (!is_wp_error($user)) {
            $validated = $this->isUserValidated($user->ID);
            return array('message' => 'Member successfully logged in', 'success' => true, 'validated' => $validated);
        } else {
            wp_send_json_error(array('message' => 'Please check your credentials'));
        }
    }

    public function isLoggedIn()
    {
        $cUser = wp_get_current_user();
        if ($cUser->ID > 0) {
            $validated = $this->isUserValidated($cUser->ID);
            return array('message' => 'Member already logged in', 'validated' => (bool)$validated, 'success' => true);
        } else {
            wp_send_json_error(array('message' => 'User not logged in'));
        }
    }

    public function resendEmail()
    {
        $user = wp_get_current_user();
        if (!is_wp_error($user)) {
            $password = get_user_meta($user->ID, self::INITIAL_PASSWORD, true);
            $token = get_user_meta($user->ID, self::UNIQUE_TOKEN, true);
            $this->sendConfirmEmail($user->user_email, $token, $password);
            return array('success' => true, 'message' => 'Email Sent');
        } else {
            wp_send_json_error(array('message' => 'There is no user with this email'));
        }
    }

    public function isUserValidated($userId)
    {
        if (user_can($userId, 'administrator')) {
            return true;
        }
        return (bool)get_user_meta($userId, self::VALIDATED, true);
    }

    public function sendEmailsForSharing()
    {
        $emails = $_POST['params']['emails'];
        $fname = $_POST['params']['fname'];
        $lname = $_POST['params']['lname'];

        $resource = $_POST['resource'];

        foreach ($emails as $email) {
            $this->sendShareResourceEmail($email, $fname, $lname, $resource);
        }
        return array('success' => true, 'message' => 'Emails Sent');
    }

    private function getMembershipPlanId()
    {
        $plans = wc_memberships_get_membership_plans();
        if ($plans) {
            return $plans[0]->id;
        }
        return null;
    }

    private function assignPlanToUser($userId)
    {
        $planId = $this->getMembershipPlanId();
        if ($planId) {
            $args = array(
                'plan_id' => $this->getMembershipPlanId(),
                'user_id' => $userId,
            );
            wc_memberships_create_user_membership($args);
        }
    }

    private function sendConfirmEmail($email, $token, $password)
    {
        $headers = 'From: info <' . get_option('admin_email') . '>';
        $to = $email;
        $subject = 'One Last Step! Confirm Your FREE Nonprofitlibrary.com Membership';
        $message = '<p>Just one <a href="' . home_url('/') . '?email_token=' . $token . '">click to confirm your free membership</a></p>';
        $message .= '<p>Your temporary password is: <b>' . $password . '</b></p>';
        $message .= '<br><p>Please bookmark <a href="nonprofitlibrary.com">nonprofitlibrary.com</a> today, we are frequently adding more valuable free resources at <a href="nonprofitlibrary.com">nonprofitlibrary.com</a>, enjoy!</p>';
        MemberHelper::send($to, $subject, $message, $headers);
    }

    private function sendShareResourceEmail($email, $fname, $lname, $resource)
    {
        $headers = 'From: info <' . get_option('admin_email') . '>';
        $to = $email;
        $subject = $fname . ' ' . $lname . ' would like to share a free nonprofit resource from ' . get_bloginfo('name') . ' with you';
        $message = '<p><b>' . $fname . ' ' . $lname . '</b> would like to share a free nonprofit resource from 
            <a href="' . get_site_url() . '">' . get_site_url() . '</a> with you</p>';
        $message .= '<p>Check out this resource at ' . get_bloginfo('name') . ' called <b><a href="' . $resource['url'] . '">'
            . $resource['title'] .
            '</a></b></p>';
        $message .= '<br><p>Please bookmark <a href="nonprofitlibrary.com">nonprofitlibrary.com</a> 
            today, we are frequently adding more valuable free resources at 
            <a href="nonprofitlibrary.com">nonprofitlibrary.com</a>, enjoy!</p>';
        MemberHelper::send($to, $subject, $message, $headers);
    }

}
