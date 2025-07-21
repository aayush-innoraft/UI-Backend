<?php

namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * @FieldFormatter(
 *   id = "rgb_static_text_formatter",
 *   label = @Translation("RGB Hex Text"),
 *   field_types = {"rgb_color"}
 * )
 */
class RGBStaticTextFormatter extends FormatterBase {
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $hex = sprintf("#%02x%02x%02x", $item->r, $item->g, $item->b);
      $elements[$delta] = ['#markup' => $hex];
    }
    return $elements;
  }
}
