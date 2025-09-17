<?php

namespace Drupal\custom_module\EventSubscriber;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 *
 */
class RouteAccessSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Check if the route exists.
    if ($route = $collection->get('custom_module.restricted_page')) {
      // Set custom access callback.
      $route->setRequirement('_custom_access', '\Drupal\custom_module\EventSubscriber\RouteAccessSubscriber::accessCheck');
    }
  }

  /**
   * Custom access check callback.
   */
  public static function accessCheck($account) {
    // Deny access if user has 'editor' role.
    if (in_array('editor', $account->getRoles())) {
      return AccessResult::forbidden();
    }

    // Otherwise check for permission.
    return $account->hasPermission('access the custom page') ?
      AccessResult::allowed() :
      AccessResult::forbidden();
  }

}
