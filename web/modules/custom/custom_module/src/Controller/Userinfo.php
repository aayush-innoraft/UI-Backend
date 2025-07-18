<?php
namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_module\Service\CurrentUserService;

class Userinfo extends ControllerBase {

  protected CurrentUserService $customUserService;

  public function __construct(CurrentUserService $user) {
    $this->customUserService = $user;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_module.my_custom_service')
    );
  }

  public function gettingUserInfo() {
    $user = $this->customUserService->getUser();

    return [
      '#markup' => "Current User ID: {$user['id']} <br> Name: {$user['name']} <br> Roles: " . implode(', ', $user['roles']),
    ];
  }
}
