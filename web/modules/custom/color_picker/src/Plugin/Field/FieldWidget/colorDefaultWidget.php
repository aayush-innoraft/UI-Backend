<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_default' widget.
 *
 * @FieldWidget(
 *   id = "color_default",
 *   label = @Translation("Color picker"),
 *   field_types = {
 *     "color"
 *   }
 * )
 */
class ColorDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick a color'),
      '#default_value' => $items[$delta]->value ?? '#000000',
    ];
    return $element;
  }

}
