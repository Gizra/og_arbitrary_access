<?php

/**
 * @file
 * Contains \OgArbitraryAccess.
 */


class OgArbitraryAccess extends Entity {

  public function __construct($values = array()) {
    parent::__construct($values, 'og_arbitrary_access');
    if (!isset($this->timestamp)) {
      $this->timestamp = time();
    }
  }
}
