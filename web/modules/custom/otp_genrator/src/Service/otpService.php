<?php
namespace Drupal\otp_genrator\Service;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Component\Utility\Random;

class otpService {

  protected $mailManager;
  protected $logger;
  protected $random;

  public function __construct(MailManagerInterface $mailManager, LoggerChannelFactoryInterface $loggerFactory) {
    $this->mailManager = $mailManager;
    $this->logger = $loggerFactory->get('otp_genrator');
    $this->random = new Random();
  }

  public function generateOtp($length = 6) {
    return $this->random->word($length);
  }

  public function sendOtpEmail($to, $otp) {
    $params = [
      'subject' => 'Your OTP Code',
      'message' => "Your OTP is: $otp",
    ];

    $result = $this->mailManager->mail('otp_genrator', 'otp_mail', $to, 'en', $params);

    if ($result['result'] !== TRUE) {
      $this->logger->error('OTP could not be sent to %email.', ['%email' => $to]);
    } else {
      $this->logger->notice('OTP sent to %email.', ['%email' => $to]);
    }
  }
}
