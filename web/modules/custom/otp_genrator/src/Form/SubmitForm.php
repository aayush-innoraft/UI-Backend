<?php

namespace Drupal\otp_genrator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\otp_genrator\Service\OtpService;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\Entity\User;

/**
 * Provides an OTP generator form.
 */
final class SubmitForm extends FormBase {

  protected $otpService;
  protected $currentUser;

  public function __construct(OtpService $otpService, AccountProxyInterface $currentUser) {
    $this->otpService = $otpService;
    $this->currentUser = $currentUser;
  }

  public static function create($container) {
    return new static(
      $container->get('otp_genrator.otp_service'),
      $container->get('current_user')
    );
  }

  public function getFormId(): string {
    return 'otp_genrator_example';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['generate_otp'] = [
      '#type' => 'button',
      '#value' => $this->t('Generate OTP'),
      '#ajax' => [
        'callback' => '::generateOtpCallback',
        'event' => 'click',
        'wrapper' => 'otp-message',
      ],
    ];

    $form['otp_message'] = [
      '#type' => 'markup',
      '#markup' => '<div id="otp-message"></div>',
    ];

    return $form;
  }

public function generateOtpCallback(array &$form, FormStateInterface $form_state) {
  try {
    $otp = $this->otpService->generateOtp();

    $account = User::load($this->currentUser->id());
    $email = $account ? $account->getEmail() : NULL;

    if ($email) {
      $this->otpService->sendOtpEmail($email, $otp);
      $form['otp_message']['#markup'] = '<div id="otp-message">OTP generated and sent to your email: ' . $email . '</div>';
    }
    else {
      $form['otp_message']['#markup'] = '<div id="otp-message">Unable to find user email.</div>';
    }
  }
  catch (\Exception $e) {
    \Drupal::logger('otp_genrator')->error('Error generating OTP: @message', ['@message' => $e->getMessage()]);
    $form['otp_message']['#markup'] = '<div id="otp-message">Error generating OTP.</div>';
  }

  return $form['otp_message'];
}


  public function submitForm(array &$form, FormStateInterface $form_state): void {}
}
