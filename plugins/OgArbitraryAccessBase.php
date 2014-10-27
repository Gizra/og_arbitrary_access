<?php

/**
 * @file
 * Contains \OgArbitraryAccessBase.
 */

abstract class OgArbitraryAccessBase implements OgArbitraryAccessInterface {


  /**
   * The plugin definition.
   *
   * @var array
   */
  protected $plugin;

  /**
   * The entity type.
   *
   * @var string
   */
  protected $entityType;

  /**
   * The bundle.
   *
   * @var string
   */
  protected $bundle;

  /**
   * The entity object.
   *
   * @var stdClass
   */
  protected $entity;

  /**
   * @param string $bundle
   */
  public function setBundle($bundle) {
    $this->bundle = $bundle;
  }

  /**
   * @return string
   */
  public function getBundle() {
    return $this->bundle;
  }

  /**
   * @param \stdClass $entity
   */
  public function setEntity($entity) {
    $this->entity = $entity;
  }

  /**
   * @return \stdClass
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * @param string $entityType
   */
  public function setEntityType($entityType) {
    $this->entityType = $entityType;
  }

  /**
   * @return string
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * @param array $plugin
   *   The plugin definition.
   * @param $entity_type
   *   The entity type.
   * @param $entity
   *   The entity object.
   */
  public function __construct(array $plugin, $entity_type, $entity) {
    $this->plugin = $plugin;
    $this->setEntityType($entity_type);
    $this->setEntity($entity);

    list(,, $bundle) = entity_extract_ids($entity_type, $entity);
    $this->setBundle($bundle);
  }

  /**
   * {@inheritdoc}
   */
  public static function getNodeGrants($plugin_name, $account = NULL, $op = 'view') {
    if (empty($account)) {
      global $user;
      $account = user_load($user->uid);
    }

    if ($op != 'view') {
      // Not a view operation.
      return;
    }

    if (!$groups = og_get_entity_groups('user', $account)) {
      // User doesn't belong ot any groups.
      return;
    }

    if (empty($groups['node'])) {
      // Groups or not of type "node".
      return;
    }


    // The "realm" name is the plugin name.
    return array($plugin_name => $groups['node']);
  }

  /**
   * {@inheritdoc}
   */
  public function getNodeAccessRecords() {}

  /**
   * Determine if handler has access.
   *
   * @param $entity_type
   * @param $entity
   *
   * @return bool|mixed
   */
  public static function access($entity_type, $entity, $op) {
    return og_is_group($entity_type, $entity) || og_get_entity_groups($entity_type, $entity);
  }

  /**
   * @todo: Allow adding reference field on the group content.
   */
  protected function getReferenceFields() {
    // Get the entity reference fields.
    $return = array();
    foreach (field_info_instances($this->getEntityType(), $this->getBundle()) as $field_name => $instance) {
      $field = field_info_field($field_name);
      if ($field['type'] != 'entityreference') {
        // Not an entity reference field.
        continue;
      }

      if ($field['settings']['target_type'] != 'og_arbitrary_access') {
        // Does not reference the OG arbitrary access entity.
        continue;
      }

      if (!empty($field['settings']['target_bundles']) && !in_array($this->getBundle(), $field['settings']['target_bundles'])) {
        // Field doesn't reference the bundle associated with the plugin.
        continue;
      }
      $return[] = $field_name;
    }

    return $return;
  }
}
