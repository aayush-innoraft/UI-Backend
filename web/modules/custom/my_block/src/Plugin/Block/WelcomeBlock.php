<?php

namespace Drupal\my_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Custom Welcome' Block.
 *
 * @Block(
 *   id = "custom_welcome_block",
 *   admin_label = @Translation("Custom Welcome Block"),
 *   category = @Translation("Custom")
 * )
 */
class WelcomeBlock extends BlockBase {

  /**
   * Builds the custom welcome block content.
   */
  public function build() {
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    $role = !empty($roles) ? ucfirst($roles[0]) : 'User';

    return [
      '#markup' => $this->t('Welcome @role', ['@role' => $role]),
    ];
  }

}
