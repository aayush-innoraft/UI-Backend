<?php
namespace Drupal\custom_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a block to display MyCustomForm.
 *
 * @Block(
 *   id = "my_form_block",
 *   admin_label = @Translation("My Custom Form Block") 
 * )
 */
class CustomFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
 return \Drupal::formBuilder()->getForm('Drupal\custom_module\Form\CustomForm');
  }

}