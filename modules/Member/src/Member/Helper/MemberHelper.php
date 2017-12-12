<?php

namespace Member\Helper;

class MemberHelper
{
  const PREFIX = 'email-confirmation-';

  public static function send($to, $subject, $message, $headers)
  {
    $token = sha1(uniqid());
    $oldData = get_option(self::PREFIX .'data') ?: array();
    $data = array();
    update_option(self::PREFIX .'data', array_merge($oldData, $data));
    wp_mail($to, $subject, $message, $headers);
  }

  public static function check($token)
  {
    $data = get_option(self::PREFIX .'data');
    $userData = $data[$token];
    if (isset($userData)) {
      unset($data[$token]);
      update_option(self::PREFIX .'data', $data);
    }
    return $userData;
  }
}