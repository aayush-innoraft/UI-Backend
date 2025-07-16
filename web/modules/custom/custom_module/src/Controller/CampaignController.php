<?php

namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class CampaignController extends ControllerBase {

  /**
   * Display the value from the dynamic route parameter.
   *
   * @param int $number
   *   The dynamic number passed via URL.
   *
   * @return array
   *   Render array.
   */
  public function showValue($number) {
    return [
      '#markup' => $this->t('The dynamic value is: @number', ['@number' => $number]),
    ];
  }
}
