<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "rgb_hex_widget",
 *   label = @Translation("Hex Code Input"),
 *   field_types = {"rgb_color"}
 * )
 */
class RGBHexWidget extends WidgetBase {
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['hex'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Code (#RRGGBB)'),
      '#default_value' => sprintf("#%02x%02x%02x", $items[$delta]->r ?? 0, $items[$delta]->g ?? 0, $items[$delta]->b ?? 0),
      '#maxlength' => 7,
      '#size' => 7,
    ];
    return $element;
  }
}
