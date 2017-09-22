<?php

namespace Drupal\fruits\Form;


use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a form for fruits type deletion.
 */
class FruitsTypeDeleteConfirm extends EntityDeleteForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $num_fruits = $this->entityTypeManager->getStorage('fruits')->getQuery()
      ->condition('type', $this->entity->id())
      ->count()
      ->execute();
    if ($num_fruits) {
      $caption = '<p>' . $this->formatPlural($num_fruits, '%type is used by 1 piece of content on your site. You can not remove this fruits type until you have removed all of the %type content.', '%type is used by @count pieces of content on your site. You may not remove %type until you have removed all of the %type content.', ['%type' => $this->entity->label()]) . '</p>';
      $form['#title'] = $this->getQuestion();
      $form['description'] = ['#markup' => $caption];
      return $form;
    }

    return parent::buildForm($form, $form_state);
  }
}