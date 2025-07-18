<?php

namespace Drupal\custom_module\Service;

use Drupal\Core\Session\AccountProxyInterface;

class CurrentUserService {

  protected $currentUser;

  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  public function getUser() {
    return [
      'id' => $this->currentUser->id(),
      'name' => $this->currentUser->getDisplayName(),
      'roles' => $this->currentUser->getRoles(),
    ];
  }
}
