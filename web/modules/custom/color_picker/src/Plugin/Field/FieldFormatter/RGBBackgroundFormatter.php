<?php

namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * @FieldFormatter(
 *   id = "rgb_background_formatter",
 *   label = @Translation("RGB Background Color"),
 *   field_types = {"rgb_color"}
 * )
 */
class RGBBackgroundFormatter extends FormatterBase {

  /**
   *
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $hex = sprintf("#%02x%02x%02x", $item->r, $item->g, $item->b);
      $elements[$delta] = [
        '#markup' => '<div style="width:50px;height:50px;background-color:' . $hex . ';"></div>',
      ];
    }
    return $elements;
  }

}
