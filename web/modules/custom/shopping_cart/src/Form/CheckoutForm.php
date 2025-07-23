<?php
namespace Drupal\shopping_cart\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Component\Utility\SafeMarkup;

class CheckoutForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'shopping_cart_checkout_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Shipping Address'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Checkout'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */

public function submitForm(array &$form, FormStateInterface $form_state) {
  $name = $form_state->getValue('name');
  $email = $form_state->getValue('email');
  $address = $form_state->getValue('address');

  $session = \Drupal::request()->getSession();
  $cart = $session->get('shopping_cart', []);

  \Drupal::messenger()->addMessage($this->t('Thank you, @name! Your order has been placed.', ['@name' => $name]));

  // Send confirmation email
  $mailManager = \Drupal::service('plugin.manager.mail');
  $module = 'shopping_cart';
  $key = 'order_confirmation';
  $to = $email;
  $params['subject'] = 'Order Confirmation';
  $params['message'] = "Hello $name,\n\nYour order for item $name has been successfully placed.\n\nShipping Address:\n$address";
  $langcode = \Drupal::currentUser()->getPreferredLangcode();
  $send = true;

  $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

  if ($result['result'] !== TRUE) {
    \Drupal::messenger()->addError($this->t('There was a problem sending your confirmation email.'));
  }

  // Clear cart
  $session->remove('shopping_cart');

  // Redirect to product list
  $url = Url::fromRoute('shopping_cart.products');
  $form_state->setRedirectUrl($url);
}
}
