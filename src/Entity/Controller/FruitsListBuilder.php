<?php

namespace Drupal\fruits\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Render\Renderer;
use Drupal\image\Entity\ImageStyle;
use Drupal\fruits\Form\FruitsSettingsForm;

/**
 * @ingroup fruits
 */
class FruitsListBuilder extends EntityListBuilder{

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Fruits implements a fruit model which is a fieldable entity. You can manage the fields on the <a href="@adminlink">Fruits admin page</a>.', [
        '@adminlink' => \Drupal::urlGenerator()
          ->generateFromRoute('fruits.fruits_settings'),
      ]),
    ];

    $build += parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getOperations(EntityInterface $entity) {
    $operations = parent::getOperations($entity);
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Fruits ID');
    $header['fruits_name'] = $this->t('Fruits Name');
    $header['fruits_body'] = $this->t('Fruits Body');
    $header['fruits_type'] = $this->t('Fruits Type');
    $header['fruits_image'] = $this->t('Fruits Image');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\fruits\Entity\Fruits */
    $row['id'] = $entity->id();
    $row['fruits_name'] = $entity->getName();
    $row['fruits_body'] = $entity->getBody();
    $row['fruits_type'] = $entity->getType();

    $config = \Drupal::config('fruits.settings');
    $fruit_image = [
      '#theme' => 'image_style',
      '#style_name' => $config->get('fruits_image_style'),
      '#uri' => $entity->fruits_image->entity->getFileUri(),
      '#attributes' => [
        'class' => 'image-responsive',
      ],
    ];
    $row['fruits_image'] = \Drupal::service('renderer')->render($fruit_image);
    return $row + parent::buildRow($entity);
  }
}