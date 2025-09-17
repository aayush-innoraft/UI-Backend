<?php

namespace Drupal\color_picker\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "rgb_values_widget",
 *   label = @Translation("RGB Values Input"),
 *   field_types = {"rgb_color"}
 * )
 */
class RGBValuesWidget extends WidgetBase {

  /**
   *
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['r'] = ['#type' => 'number', '#title' => 'Red', '#default_value' => $items[$delta]->r ?? 0];
    $element['g'] = ['#type' => 'number', '#title' => 'Green', '#default_value' => $items[$delta]->g ?? 0];
    $element['b'] = ['#type' => 'number', '#title' => 'Blue', '#default_value' => $items[$delta]->b ?? 0];
    return $element;
  }

}
