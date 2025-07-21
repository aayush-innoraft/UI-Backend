<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "rgb_color_picker_widget",
 *   label = @Translation("Color Picker"),
 *   field_types = {"rgb_color"}
 * )
 */
class RGBColorPickerWidget extends WidgetBase {
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $hex_value = sprintf("#%02x%02x%02x", $items[$delta]->r ?? 0, $items[$delta]->g ?? 0, $items[$delta]->b ?? 0);

    $element['color'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick a color'),
      '#default_value' => $hex_value,
    ];

    return $element;
  }
}
