<?php

/**
 * @file
 * Contains \OgArbitraryAccessEmailDomain.
 */

class OgArbitraryAccessEmailDomain extends OgArbitraryAccessBase {

  /**
   * {@inheritdoc}
   */
  public static function getNodeGrants($account = NULL, $op = 'view') {
    if (empty($account)) {
      global $user;
      $account = user_load($user->uid);
    }

    if (!$account->uid) {
      // Anonymous user.
      return array();
    }

    if ($op != 'view') {
      // Not a view operation.
      return array();
    }

    $email_domain = explode('@', $account->mail);
    // The "realm" name is the plugin name.
    return array(get_called_class() => array($email_domain[1]));
  }

  /**
   * {@inheritdoc}
   */
  public function getNodeAccessRecords() {}
}
