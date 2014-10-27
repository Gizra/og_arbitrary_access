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
   * The entity object.
   *
   * @var stdClass
   */
  protected $entity;

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
   * @param array $plugin
   *   The plugin definition.
   * @param $entity_type
   *   The entity type.
   * @param $entity
   *   The entity object.
   */
  public function __construct(array $plugin, $entity_type, $entity) {
    $this->plugin = $plugin;
    $this->setEntity($entity);
  }

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
    $bundle = $this->getEntity()->type;
    foreach (field_info_instances('node', $bundle) as $field_name => $instance) {
      $field = field_info_field($field_name);
      if ($field['type'] != 'entityreference') {
        // Not an entity reference field.
        continue;
      }

      if ($field['settings']['target_type'] != 'og_arbitrary_access') {
        // Does not reference the OG arbitrary access entity.
        continue;
      }

      if (!empty($field['settings']['target_bundles']) && !in_array($this->plugin['name'], $field['settings']['target_bundles'])) {
        // Field doesn't reference the bundle associated with the plugin.
        continue;
      }
      $return[] = $field_name;
    }

    return $return;
  }
}
