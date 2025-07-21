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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#default_value' => $items[$delta]->r ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#default_value' => $items[$delta]->g ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#default_value' => $items[$delta]->b ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    return $element;
  }
}
