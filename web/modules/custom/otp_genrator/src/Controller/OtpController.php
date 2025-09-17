<?php

namespace Drupal\otp_genrator\Controller;

use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\otp_genrator\Service\OtpService;

/**
 *
 */
class OtpController extends ControllerBase {
  protected $otpService;

  public function __construct(OtpService $otpService) {
    $this->otpService = $otpService;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('otp_genrator.otp_service')
      );
  }

  /**
   *
   */
  public function genrateAndSendOtp() {
    $otp = $this->otpService->generateOtp();

    $user = \Drupal::currentUser();
    $account = User::load($user->id());
    $email = $account ? $account->getEmail() : '';

    if (!$email) {
      return new JsonResponse(['message' => 'User email not found.'], 400);
    }

    // Store OTP in tempstore.
    $tempstore = \Drupal::service('user.private_tempstore')->get('otp_genrator');
    $tempstore->set('user_otp', $otp);

    $this->otpService->sendOtpEmail($email, $otp);

    return new JsonResponse(['message' => 'OTP sent!', 'otp' => $otp]);
  }

}
