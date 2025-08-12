<?php

namespace Drupal\movie\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class BudgetConfigForm extends ConfigFormBase {

  /**
   *
   */
  public function getFormId() {
    return 'movie_config_form';
  }

  /**
   *
   */
  public function getEditableConfigNames() {
    return ['movie.settings'];
  }

  /**
   *
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('movie.settings');
    $form['budget'] = [
      '#type' => 'number',
      '#title' => $this->t('Budget Amount'),
      '#default_value' => $config->get('budget'),
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   *
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('movie.settings')
      ->set('budget', $form_state->getValue('budget'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
