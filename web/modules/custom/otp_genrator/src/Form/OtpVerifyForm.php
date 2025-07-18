<?php

namespace Drupal\otp_genrator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form to verify the OTP.
 */
class OtpVerifyForm extends FormBase {

  public function getFormId() {
    return 'otp_genrator_otp_verify_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter OTP'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Verify OTP'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entered_otp = $form_state->getValue('otp');

    $tempstore = \Drupal::service('user.private_tempstore')->get('otp_genrator');
    $stored_otp = $tempstore->get('user_otp');

    if ($stored_otp && $entered_otp == $stored_otp) {
      \Drupal::messenger()->addStatus($this->t('OTP verified successfully.'));
      $tempstore->delete('user_otp');
    }
    else {
      \Drupal::messenger()->addError($this->t('Invalid or expired OTP.'));
    }
  }
}
