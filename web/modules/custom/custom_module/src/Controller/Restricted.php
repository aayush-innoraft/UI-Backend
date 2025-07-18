<?php

namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\node\Plugin\views\filter\Access;

class Restricted extends ControllerBase
{

  /**
   * Returns the content for the restricted page.
   */

  public function restrictedContent()
  {
    return [
      '#markup' => $this->t('Welcome to the restricted page.'),
    ];
  }

  /**
   * Custom access check for the restricted page.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user account object.
   *
   * @return \Drupal\Core\Access\AccessResult
   *   The access result.
   */

  public static function accessCheck(AccountInterface $account)
  {
    // Example condition: user must have the 'access the custom page' permission.
    if ($account->hasPermission('access the custom page')) {
      return AccessResult::allowed();
    }

    // Additional example: restrict access based on role
    if (in_array('editor', $account->getRoles())) {
      return AccessResult::forbidden();
    }
    // Default deny.
    return AccessResult::forbidden();
  }
}
