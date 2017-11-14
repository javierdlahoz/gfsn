<?php

namespace Member\Controller;

use Member\Helper\MemberHelper;

class MemberController
{

    const UNIQUE_TOKEN = 'unique_token';
    const DOWNLOADED_PRODUCTS = 'downloaded_products';
    const VALIDATED = 'email_validated';
    const INITIAL_PASSWORD = 'initial_password';
    const REDIRECT_URL = 'gfsn-redirect-url';
    const DOWNLOADED_TIMES = 'downloaded_times';
    const TAG = 'gfsn-tag';
    const TWO_DAYS_INTERVAL = 'P2D';
    const ONE_DAY_INTERVAL = 'P1D';

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

        if ($user) {
            update_user_meta($user, self::UNIQUE_TOKEN, $uniqueToken);
            update_user_meta($user, self::VALIDATED, false);
            update_user_meta($user, self::INITIAL_PASSWORD, $password);
            update_user_meta($user, self::REDIRECT_URL, $_POST['redirectUrl']);
            if ($_POST['tag']) {
                update_user_meta($user, self::TAG, $_POST['tag']);
            }

            $this->sendConfirmEmail($_POST['email'], $uniqueToken, $password, $_POST['tag']);
            $this->scheduleFirstReminderEmail($user);

            return array('message' => 'Member successfully subscribed', 'validated' => false, 'success' => true);
        } else {
            wp_send_json_error($user);
        }
    }

    public function trackDownloads()
    {
        $productId = $_POST['productId'];
        $user = \wp_get_current_user();
        $downloadedProducts = get_user_meta($user->ID, self::DOWNLOADED_PRODUCTS, true);
        $downloadedTimes = (int) \get_post_meta($productId, self::DOWNLOADED_TIMES, true);
        \update_post_meta($productId, self::DOWNLOADED_TIMES, ($downloadedTimes + 1));

        if (!in_array($productId, $downloadedProducts)) {
            $downloadedProducts[] = $productId;
        }
        update_user_meta($user->ID, self::DOWNLOADED_PRODUCTS, $downloadedProducts);
        return array('message' => 'Product download tracked successfully');
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

    public function sendFirstConfirmationReminderEmail($userId)
    {
        $user = get_user_by('ID', $userId);
        if (!$this->isUserValidated($userId)) {
            $uniqueToken = get_user_meta($user->ID, self::UNIQUE_TOKEN, true);
            $password = get_user_meta($user->ID, self::INITIAL_PASSWORD, true);
            $tag = get_user_meta($user->ID, self::TAG, true);
            $this->sendFirstReminderEmail($user->user_email, $uniqueToken, $password, $tag);
            $this->scheduleSecondReminderEmail($user->ID);
        }
    }

    public function sendSecondConfirmationReminderEmail($userId)
    {
        $user = get_user_by('ID', $userId);
        if (!$this->isUserValidated($userId)) {
            $uniqueToken = get_user_meta($user->ID, self::UNIQUE_TOKEN, true);
            $password = get_user_meta($user->ID, self::INITIAL_PASSWORD, true);
            $tag = get_user_meta($user->ID, self::TAG, true);
            $this->sendSecondReminderEmail($user->user_email, $uniqueToken, $password, $tag);
        }
    }

    private function scheduleFirstReminderEmail($userId = null) 
    {
        $time = new \DateTime();
        $time->add(new \DateInterval(self::TWO_DAYS_INTERVAL));
        $event = wp_schedule_single_event($time->getTimestamp(), 'send_first_reminder_email', [$userId]);
        //$this->sendFirstConfirmationReminderEmail($user);
    }

    private function scheduleSecondReminderEmail($userId = null) 
    {
        $time = new \DateTime();
        $time->add(new \DateInterval(self::ONE_DAY_INTERVAL));
        $event = wp_schedule_single_event($time->getTimestamp(), 'send_second_reminder_email', [$userId]);
        //$this->sendSecondConfirmationReminderEmail($user);
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

    private function sendConfirmEmail($email, $token, $password, $tag = null)
    {
        $url = home_url('/') . '?email_token=' . $token;
        if ($tag) {
            $url .= '&dtag=' . $tag;
        }

        $headers = 'From: info <' . get_option('admin_email') . '>';
        $to = $email;
        $subject = 'One Last Step! Confirm Your FREE Nonprofitlibrary.com Membership';
        $message = '<p>Just one <a href="' . $url . '">click to confirm your free membership</a></p>';
        $message .= '<p>Your temporary password is: <b>' . $password . '</b></p>';
        $message .= '<br><p>Please bookmark <a href="nonprofitlibrary.com">nonprofitlibrary.com</a> today, we are frequently adding more valuable free resources at <a href="nonprofitlibrary.com">nonprofitlibrary.com</a>, enjoy!</p>';
        MemberHelper::send($to, $subject, $message, $headers);
    }

    private function sendFirstReminderEmail($email, $token, $password, $tag = null)
    {
        $url = home_url('/') . '?email_token=' . $token;
        if ($tag) {
            $url .= '&dtag=' . $tag;
        }

        $headers = 'From: info <' . get_option('admin_email') . '>';
        $to = $email;
        $subject = "Thanks for visiting Nonprofit Library - Confirm Your Membership Today!";
        $message = '<p>Thank you for visiting Nonprofit Library. We are frequently adding new FREE resources to help you and your nonprofit organization.</p>';
        $message .= '<p>Confirm your membership today to have instant access to our entire resource library.<br>';
        $message .= '<a href="' . $url . '">click to confirm your free membership</a></p>';
        $message .= '<p>Your temporary password is: <b>' . $password . '</b></p>';
        MemberHelper::send($to, $subject, $message, $headers);
    }

    private function sendSecondReminderEmail($email, $token, $password, $tag = null)
    {
        $url = home_url('/') . '?email_token=' . $token;
        if ($tag) {
            $url .= '&dtag=' . $tag;
        }

        $headers = 'From: info <' . get_option('admin_email') . '>';
        $to = $email;
        $subject = "One Last Step! Confirm Your FREE Nonprofitlibrary.com Membership";
        $message = '<p>Free Instant Access Educational Resources for Nonprofit Professionals!</p>';
        $message = '<p>Just one <a href="' . $url . '">click to confirm your free membership</a></p>';
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
