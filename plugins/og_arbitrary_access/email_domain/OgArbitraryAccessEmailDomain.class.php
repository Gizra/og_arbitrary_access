<?php

/**
 * @file
 * Contains \OgArbitraryAccessEmailDomain.
 */

class OgArbitraryAccessEmailDomain extends OgArbitraryAccessBase {

  /**
   * {@inheritdoc}
   */
  public function getNodeGrants() {}

  /**
   * {@inheritdoc}
   */
  public function getNodeAccessRecords() {}

  /**
   * {@inheritdoc}
   */
  public static function access($entity_type, $entity) {
    if (!parent::access($entity_type, $entity)) {
      return;
    }

    if (og_is_group($entity_type, $entity)) {

    }
  }
}
