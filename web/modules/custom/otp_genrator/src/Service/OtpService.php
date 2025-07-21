<?php

namespace Drupal\otp_genrator\Service;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Service to handle OTP generation and sending via email.
 */
class OtpService {

  protected $mailManager;
  protected $logger;

  public function __construct(MailManagerInterface $mailManager, LoggerChannelFactoryInterface $loggerFactory) {
    $this->mailManager = $mailManager;
    $this->logger = $loggerFactory->get('otp_genrator');
  }

  public function generateOtp($length = 6) {
    // Generate numeric OTP
    return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
  }

  public function sendOtpEmail(string $to, string $otp): void {
    $params = [
      'subject' => 'Your OTP Code',
      'message' => "Your OTP is: $otp",
    ];

    $result = $this->mailManager->mail('otp_genrator', 'otp_mail', $to, 'en', $params);
    var_dump($result); // Debugging line, can be removed later

    if (!empty($result['result'])) {
      $this->logger->notice('OTP sent to %email.', ['%email' => $to]);
    } else {
      $this->logger->error('Failed to send OTP to %email.', ['%email' => $to]);
    }
  }
}