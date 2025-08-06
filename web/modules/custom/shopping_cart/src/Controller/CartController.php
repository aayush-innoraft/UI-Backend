<?php

namespace Drupal\shopping_cart\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends ControllerBase {

  /**
   * Returns the list of products with names and prices.
   */
  private function getProducts() {
    return [
      1 => ['name' => 'T-shirt', 'price' => 499],
      2 => ['name' => 'Cap', 'price' => 299],
      3 => ['name' => 'Shoes', 'price' => 1999],
      4 => ['name' => 'Jacket', 'price' => 2499],
      5 => ['name' => 'Watch', 'price' => 1499],
      6 => ['name' => 'Sunglasses', 'price' => 899],
      7 => ['name' => 'Jeans', 'price' => 1099],
      8 => ['name' => 'Hoodie', 'price' => 1299],
      9 => ['name' => 'Backpack', 'price' => 1599],
      10 => ['name' => 'Sneakers', 'price' => 2199],
      11 => ['name' => 'Hat', 'price' => 349],
      12 => ['name' => 'Wallet', 'price' => 799],
    ];
  }

  /**
   * Displays the list of products.
   */
  public function productList() {
    $products = $this->getProducts();

    $output = "<h2>🛒 Product List</h2><ul>";
    foreach ($products as $id => $info) {
      $name = $info['name'];
      $price = $info['price'];
      $link = "/shopping-cart/add/{$id}";
      $output .= "<li>{$name} - ₹{$price} <a href='{$link}'>Add to cart</a></li>";
    }
    $output .= "</ul>";

    return [
      '#markup' => $output,
      '#cache' => ['max-age' => 0],
    ];
  }

  /**
   * Adds a product to the shopping cart.
   */
  public function addToCart($id, Request $request) {
    $products = $this->getProducts();

    if (!isset($products[$id])) {
      $this->messenger()->addError("Invalid product.");
      return new RedirectResponse('/shopping-cart/products');
    }

    $session = $request->getSession();
    $cart = $session->get('shopping_cart', []);

    // Add or update product quantity.
    if (!isset($cart[$id])) {
      $cart[$id] = 1;
    } else {
      $cart[$id]++;
    }

    $session->set('shopping_cart', $cart);
    $this->messenger()->addMessage("✅ {$products[$id]['name']} added to cart.");

    return new RedirectResponse('/shopping-cart/products');
  }

  /**
   * Removes a product from the shopping cart.
   */
  public function removeFromCart($id, Request $request) {
    $session = $request->getSession();
    $cart = $session->get('shopping_cart', []);

    if (isset($cart[$id])) {
      unset($cart[$id]);
      $session->set('shopping_cart', $cart);
      $this->messenger()->addMessage("❌ Product removed from cart.");
    } else {
      $this->messenger()->addWarning("Product not found in cart.");
    }

    return new RedirectResponse('/shopping-cart/view');
  }

  /**
   * Shows cart contents and total price.
   */
  public function viewCart() {
    $products = $this->getProducts();
    $session = \Drupal::request()->getSession();
    $cart = $session->get('shopping_cart', []);

    $output = "<h2>🛍️ Your Cart</h2>";
    $total = 0;

    if (empty($cart)) {
      $output .= "<p>Your cart is empty.</p>";
    } else {
      $output .= "<ul>";
      foreach ($cart as $id => $quantity) {
        if (isset($products[$id])) {
          $name = $products[$id]['name'];
          $price = $products[$id]['price'];
          $item_total = $price * $quantity;
          $total += $item_total;

          $remove_link = "/shopping-cart/remove/{$id}";
          $output .= "<li>{$name} - ₹{$price} x {$quantity} = <strong>₹{$item_total}</strong>
            <a href='{$remove_link}' style='color:red; margin-left:10px;'>❌ Remove</a></li>";
        } else {
          $output .= "<li>Unknown item x {$quantity}</li>";
        }
      }
      $output .= "</ul>";
      $output .= "<p><strong>🧾 Total Amount: ₹{$total}</strong></p>";
      $output .= "<a href='/shopping-cart/checkout'>Go to Checkout</a>";
    }

    return [
      '#markup' => $output,
      '#cache' => ['max-age' => 0],
    ];
  }

}
