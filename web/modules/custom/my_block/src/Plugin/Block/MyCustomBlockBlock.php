<?php

declare(strict_types=1);

namespace Drupal\my_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a my_block block.
 *
 * @Block(
 *   id = "my_custom_block",
 *   admin_label = @Translation("my_block"),
 *   category = @Translation("Custom"),
 * )
 */
final class MyCustomBlockBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly AccountProxyInterface $currentUser,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self
  {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array
  {
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    $role = !empty($roles) ? ucfirst($roles[0]) : 'User';

    $build = [
      '#markup' => $this->t('Welcome @role', ['@role' => $role]),
    ];
    return $build;
  }
}
