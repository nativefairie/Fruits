<?php

namespace Drupal\fruits\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\ContentEntityForm;

/**
 * Class FruitsSettingsForm.
 * @package Drupal\fruits\Form
 * @ingroup fruits
 */
class FruitsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'fruits.settings',
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'fruits_settings_form';
  }

  /**
   * Define the form used for ContentEntityExample settings.
   * @return array
   *   Form definition array.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param FormStateInterface $form_state
   *   An associative array containing the current state of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    $config_fruits = $this->config('fruits.settings')->get('fruits_image_style');
    $image_styles_options = image_style_options(FALSE);

    $form['fruits_settings'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Fruits Settings'),
      '#description' => $this->t('Enter your Fruits Settings details for the image.'),
    );
    $form['fruits_settings']['fruits_image_style'] = array(
      '#title' => t('Choose Image Style for Fruits Images'),
      '#type' => 'select',
      '#default_value' => $config_fruits = $this->config('fruits.settings')->get('fruits_image_style'),
      '#options' => $image_styles_options,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param FormStateInterface $form_state
   *   An associative array containing the current state of the form.
   *
   * {@inheritdoc}
   *
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Store the fruits config
    $config_fruits = $this->config('fruits.settings');
    $config_fruits->set('fruits_image_style', $form_state->getValue('fruits_image_style'));
    $config_fruits->save();

  }
}