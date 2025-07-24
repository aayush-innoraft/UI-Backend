<?php

namespace Drupal\movie\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block to show the last content creator's name.
 *
 * @Block(
 *   id = "last_user_block",
 *   admin_label = @Translation("Last Node Creator")
 * )
 */
class LastUserBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $cached = \Drupal::cache()->get('movie.last_created_user');
    $username = $cached ? $cached->data : $this->t('No data yet.');
    
    return [
      '#markup' => $this->t('Last node was created by: @user', ['@user' => $username]),
    ];
  }
}
