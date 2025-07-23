<?php

namespace Drupal\shopping_cart\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\SessionManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a Shopping Cart block.
 *
 * @Block(
 *   id = "shopping_cart_block",
 *   admin_label = @Translation("Shopping Cart Block")
 * )
 */
class CartBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    protected $sessionManager;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, SessionManagerInterface $session_manager)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->sessionManager = $session_manager;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('session_manager')
        );
    }

    public function build()
    {
        $session = \Drupal::request()->getSession();
        $cart = $session->get('shopping_cart', []);
        $totalItems = array_sum($cart);

        return [
            '#markup' => '<div><strong>Cart:</strong> ' . $totalItems . ' item(s)</div>',
            '#cache' => [
                'max-age' => 0, // This will prevent the caching of this page.
            ],
        ];
    }
}
