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
 *   bundle_label = @Translation("Fruits type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\fruits\Entity\Controller\FruitsListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\fruits\Form\FruitsForm",
 *       "add" = "Drupal\fruits\Form\FruitsForm",
 *       "edit" = "Drupal\fruits\Form\FruitsForm",
 *       "delete" = "Drupal\fruits\Form\FruitsDeleteForm",
 *     },
 *     "access" = "Drupal\fruits\FruitsAccessControlHandler",
 *   },
 *   fieldable = TRUE,
 *   admin_permission = "administer fruits entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "fruits_name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   bundle_entity_type = "fruits_type",
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.fruits_type.edit_form",
 *   links = {
 *     "canonical" = "/admin/content/fruits/{fruits}",
 *     "edit-form" = "/admin/content/fruits/{fruits}/edit",
 *     "delete-form" = "/admin/content/fruits/{fruits}/delete",
 *     "collection" = "/admin/content/fruits/collection"
 *   },
 * )
 */

class Fruits extends ContentEntityBase implements FruitsInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTimeAcrossTranslations()  {
    $changed = $this->getUntranslated()->getChangedTime();
    foreach ($this->getTranslationLanguages(FALSE) as $language)    {
      $translation_changed = $this->getTranslation($language->getId())->getChangedTime();
      $changed = max($translation_changed, $changed);
    }
    return $changed;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

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
   *
   * @param $fruits_body
   */
  public function setBody($fruits_body) {
    $this->get('fruits_body')->value = $fruits_body;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Fruits entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Fruits.'))
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

    // Owner field of the contact.
    // Entity reference field, holds the reference to the user object.
    // The view shows the user name field of the user.
    // The form presents a auto complete field for the user name.
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User Name'))
      ->setDescription(t('The Name of the associated user.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of Contact entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}