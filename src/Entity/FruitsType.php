<?php

namespace Drupal\fruits\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\fruits\FruitsTypeInterface;

/**
 * Defines the Fruits type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "fruits_type",
 *   label = @Translation("Fruits type"),
 *   handlers = {
 *     "access" = "Drupal\fruits\FruitsTypeAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\fruits\Form\FruitsTypeForm",
 *       "add" = "Drupal\fruits\Form\FruitsTypeForm",
 *       "edit" = "Drupal\fruits\Form\FruitsTypeForm",
 *       "delete" = "Drupal\fruits\Form\Form\FruitsTypeDeleteConfirm"
 *     },
 *     "list_builder" = "Drupal\fruits\FruitsTypeListBuilder",
 *   },
 *   admin_permission = "administer content types",
 *   config_prefix = "type",
 *   bundle_of = "fruits",
 *   entity_keys = {
 *     "id" = "type",
 *     "label" = "name"
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/fruits_types/manage/{node_type}",
 *     "delete-form" = "/admin/structure/fruits_types/manage/{node_type}/delete",
 *     "collection" = "/admin/structure/fruits_types",
 *   },
 *   config_export = {
 *     "name",
 *     "type",
 *     "description",
 *   }
 * )
 */
class FruitsType extends ConfigEntityBundleBase implements FruitsTypeInterface {

  /**
   * The machine name of this fruits type.
   *
   * @var string
   */
  protected $type;

  /**
   * The human-readable name of the fruits type.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this fruits type.
   *
   * @var string
   */
  protected $description;

  /**
   * Display setting for author and date Submitted by post information.
   *
   * @var bool
   */
  protected $display_submitted = TRUE;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->type;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    $locked = \Drupal::state()->get('fruits.type.locked');
    return isset($locked[$this->id()]) ? $locked[$this->id()] : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function displaySubmitted() {
    return $this->display_submitted;
  }

  /**
   * {@inheritdoc}
   */
  public function setDisplaySubmitted($display_submitted) {
    $this->display_submitted = $display_submitted;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

    if ($update) {
      // Clear the cached field definitions as some settings affect the field
      // definitions.
      $this->entityManager()->clearCachedFieldDefinitions();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);

    // Clear the fruits type cache to reflect the removal.
    $storage->resetCache(array_keys($entities));
  }

}
