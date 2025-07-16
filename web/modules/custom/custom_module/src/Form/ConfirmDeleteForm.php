<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class ConfirmDeleteForm extends ConfirmFormBase {

  protected $id;

  public function getFormId() {
    return 'custom_module_confirm_delete_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, ?string $id = NULL) {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  public function getQuestion() {
    return $this->t('Are you sure you want to delete the record with email: %email?', ['%email' => base64_decode($this->id)]);
  }

  public function getCancelUrl() {
    return Url::fromRoute('custom_module.show_data');
  }

  public function getConfirmText() {
    return $this->t('Delete');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::database();
    $deleted = $connection->delete('custom_module')
      ->condition('email', base64_decode($this->id))
      ->execute();

    if ($deleted) {
      $this->messenger()->addMessage($this->t('The record has been deleted.'));
    } else {
      $this->messenger()->addError($this->t('Record not found.'));
    }

    $form_state->setRedirect('custom_module.show_data');
  }
}
