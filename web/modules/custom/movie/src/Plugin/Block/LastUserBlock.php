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
    $uid = \Drupal::currentUser()->id();

    return [
      '#markup' => $this->t('Last movie node was created by: @user</br>Current user UID: @uid', [
        '@user' => $username,
        '@uid' => $uid,
      ]),
    ];
  }

}
