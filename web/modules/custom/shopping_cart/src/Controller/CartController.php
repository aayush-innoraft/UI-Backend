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
    // Define a list of products.
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

    // Prepare the output as an HTML list.
    $output = "<h2>Product List</h2><ul>";
    foreach ($items as $item) {
        $link = '/shopping-cart/add/' . $item['id'];
        $output .= "<li>{$item['name']} <a href='$link'>Add to cart</a></li>";
    }
    $output .= "</ul>";

    return [
        '#markup' => $output,
         '#cache' => [
            'max-age' => 0, // This will prevent the caching of this page.
        ],
    ];
  }

  /**
   * Adds a product to the shopping cart.
   */
  public function addToCart($id, Request $request) {
    $session = $request->getSession();
    $cart = $session->get('shopping_cart', []);

    // Check if the product already exists in the cart and increment its quantity.
    if (!isset($cart[$id])) {
      $cart[$id] = 1; // Add the product with quantity 1.
    } else {
      $cart[$id]++; // Increment the quantity if the product is already in the cart.
    }

    // Save the updated cart back to the session.
    $session->set('shopping_cart', $cart);
    $this->messenger()->addMessage("Item $id added to cart.");

    return new RedirectResponse('/shopping-cart/products');
  }

  /**
   * Displays the current cart contents.
   */
  public function viewCart() {
    // Get the shopping cart from the session.
    $session = \Drupal::request()->getSession();
    $cart = $session->get('shopping_cart', []);

    // Build the cart display.
    $output = "<h2>Your Cart</h2>";
    if (empty($cart)) {
      $output .= "<p>Your cart is empty.</p>";
    } else {
      $output .= "<ul>";
      foreach ($cart as $id => $quantity) {
        $output .= "<li>Item $id - Quantity: $quantity</li>";
      }
      $output .= "</ul>";
      $output .= "<a href='/shopping-cart/checkout'>Go to Checkout</a>";
    }

    return [
      '#markup' => $output,
       '#cache' => [
            'max-age' => 0, // This will prevent the caching of this page.
        ],
    ];
  }
}
