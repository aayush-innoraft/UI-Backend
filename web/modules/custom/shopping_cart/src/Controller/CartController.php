<?php
namespace Drupal\shopping_cart\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends ControllerBase {

  /**
   * Displays a simple list of products.
   */
public function productList() {
    $items = [
        ['id' => 1, 'name' => 'T-shirt'],
        ['id' => 2, 'name' => 'Cap'],
        ['id' => 3, 'name' => 'Shoes'],
        ['id' => 4, 'name' => 'Jacket'],
        ['id' => 5, 'name' => 'Watch'],
        ['id' => 6, 'name' => 'Sunglasses'],
        ['id' => 7, 'name' => 'Jeans'],
        ['id' => 8, 'name' => 'Hoodie'],
        ['id' => 9, 'name' => 'Backpack'],
        ['id' => 10, 'name' => 'Sneakers'],
        ['id' => 11, 'name' => 'Hat'],
        ['id' => 12, 'name' => 'Wallet'],
    ];

    $output = "<h2>Product List</h2><ul>";
    foreach ($items as $item) {
        $link = '/shopping-cart/add/' . $item['id'];
        $output .= "<li>{$item['name']} <a href='$link'>Add to cart</a></li>";
    }
    $output .= "</ul>";

    return [
        '#markup' => $output,
    ];
}


  /**
   * Adds a product to session cart.
   */
  public function addToCart($id, Request $request) {
    $session = $request->getSession();
    $cart = $session->get('shopping_cart', []);

    if (!isset($cart[$id])) {
      $cart[$id] = 1;
    } else {
      $cart[$id]++;
    }

    $session->set('shopping_cart', $cart);
    $this->messenger()->addMessage("Item $id added to cart.");

    return new RedirectResponse('/shopping-cart/products');
  }
}
