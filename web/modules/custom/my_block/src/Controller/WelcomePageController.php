<?php

namespace Drupal\my_block\Controller;


use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for my_block routes.
 */
class WelcomePageController extends ControllerBase {

  /**
   * Returns the custom welcome page content.
   */
  public function welcome() {
    return [
      '#markup' => $this->t('Welcome to the custom welcome page!'),
    ];
  }

}
