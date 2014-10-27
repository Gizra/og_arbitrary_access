<?php

/**
 * @file
 * Contains \OgArbitraryAccessInterface.
 */

interface OgArbitraryAccessInterface {

  /**
   * @return mixed
   *
   * @see hook_node_grants()
   */
  public function getNodeGrants();

  /**
   * @return mixed
   *
   * @see hook_node_access_records()
   */
  public function getNodeAccessRecords();

  /**
   * @param $entity_type
   * @param $entity
   * @return mixed
   */
  public static function access($entity_type, $entity);
}
