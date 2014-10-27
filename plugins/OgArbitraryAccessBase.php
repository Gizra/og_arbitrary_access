<?php

/**
 * @file
 * Contains \OgArbitraryAccessBase.
 */

abstract class OgArbitraryAccessBase implements OgArbitraryAccessInterface {

  /**
   * {@inheritdoc}
   */
  public function getNodeGrants() {}

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
  public static function access($entity_type, $entity) {
    return og_is_group($entity_type, $entity) || og_get_entity_groups($entity_type, $entity);
  }

  /**
   * @todo: Allow adding reference field on the group cotnent.
   */
  protected function getReferenceFields() {
    // Get the entity reference fields.
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
      }


    }
  }
}
