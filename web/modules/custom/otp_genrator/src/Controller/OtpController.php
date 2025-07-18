<?php
namespace Drupal\otp_genrator\Controller;

use Drupal\Core\Controller\ControllerBase;
use symfony\component\DependencyInjection\ContainerInterface;
use symfony\component\HttpFoundation\JsonResponse;
use Drupal\otp_genrator\Service\OtpService;

class OtpController extends ControllerBase{
    protected $otpservice;

    public function __construct(OtpService $otpservice){
        $this->otpservice =  $otpservice;
    }
    public static function create(ContainerInterface $container){
        return new static(
            $container->get('  otp_genrator.otp_service')
        );
    }
    public function genrateAndSendOtp(){
        $otp = $this->otpservice->generateOtp();
        $user = \Drupal::currentUser();
        $account = \Drupal\user\Entity\User::load($user->id());
        $email = $account->getEmail();
        $this->otpservice->sendOtpEmail($email,$otp);
        return new JsonResponse(['message' => 'OTP sent !' , 'otp' => $otp]);
    }
}