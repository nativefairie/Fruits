<?php

/**
 * @file
 * Contains \Drupal\fruits\Entity\Fruits.
 */

namespace Drupal\fruits\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\fruits\FruitsInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the Fruits entity.
 *
 * @ingroup fruits
 *
 * @ContentEntityType(
 *   id = "fruits",
 *   label = @Translation("Fruits"),
 *   base_table = "fruits",
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\fruits\Entity\Controller\FruitsListBuilder",
 *     "form" = {
 *       "add" = "Drupal\fruits\Form\FruitsForm",
 *       "edit" = "Drupal\fruits\Form\FruitsForm",
 *       "delete" = "Drupal\fruits\Form\FruitsDeleteForm",
 *     },
 *     "access" = "Drupal\fruits\FruitsAccessControlHandler",
 *   },
 *   admin_permission = "administer fruits entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "fruits_name",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/fruits/{fruits}",
 *     "edit-form" = "/fruits/{fruits}/edit",
 *     "delete-form" = "/fruits/{fruits}/delete",
 *     "collection" = "/fruits/collection"
 *   },
 *   field_ui_base_route = "fruits/fruits_settings",
 * )
 */

class Fruits extends ContentEntityBase implements FruitsInterface {

  use EntityChangedTrait;
  /**
   * Gets the value for the fruits_image field of a fruits entity.
   */
  public function getImage() {
    return $this->get('fruits_image')->value;
  }
  /**
   * Sets the value for the fruits_image filed of a fruits entity.
   *
   * @param $fruits_image
   */
  public function setImage($fruits_image) {
    $this->get('fruits_image')->value = $fruits_image;
  }
  /**
   * Gets the value for the fruits_type field of a fruits entity.
   */
  public function getType() {
    return $this->get('fruits_type')->value;
  }
  /**
   * Sets the value for the fruits_type filed of a fruits entity.
   */
  public function setType($fruits_type) {
    $this->get('fruits_type')->value = $fruits_type;
  }
  /**
   * Gets the value for the fruits_name field of a fruits entity.
   */
  public function getName() {
    return $this->get('fruits_name')->value;
  }
  /**
   * Sets the value for the fruits_name filed of a fruits entity.
   */
  public function setName($fruits_name) {
    $this->get('fruits_name')->value = $fruits_name;
  }
  /**
   * Gets the value for the fruits_body field of a fruits entity.
   */
  public function getBody() {
    return $this->get('fruits_body')->value;
  }
  /**
   * Sets the value for fruits_body of a fruits entity.
   */
  public function setBody($fruits_body) {
    $this->get('fruits_body')->value = $fruits_body;
  }

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID assigned to each fruit'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The Unique IDentifier assigned to each fruit entity'))
      ->setReadOnly(TRUE);

    $fields['fruits_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('The fruits name'))
      ->setDescription(t('The name of the fruit'))
      ->setSettings(array(
        'default_value' => 'Apple',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' =>'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['fruits_body'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Body'))
      ->setDescription(t('A descriptive blurb for the fruit'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' =>'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['fruits_type'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Type'))
      ->setDescription(t('The type of the fruit entity.'))
      ->setSettings(array(
        'allowed_values' => array(
          'local' => 'local',
          'exotic' => 'exotic',
        ),
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['fruits_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('The fruits image'))
      ->setDescription(t('The image of the fruit'))
      ->setSettings([
        'file_directory' => 'Downloads',
        'alt_field_required' => FALSE,
        'file_extensions' => 'png jpg jpeg',
      ])
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'default',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'image_image',
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
}
}