<?php

namespace Drupal\movie\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class AwardWinningMovieDeleteForm extends EntityConfirmFormBase {

  /**
   *
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %name?', ['%name' => $this->entity->label()]);
  }

  /**
   *
   */
  public function getCancelUrl() {
    return $this->entity->toUrl('collection');
  }

  /**
   *
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   *
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();
    $this->messenger()->addMessage($this->t('Award-winning movie %label has been deleted.', ['%label' => $this->entity->label()]));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
