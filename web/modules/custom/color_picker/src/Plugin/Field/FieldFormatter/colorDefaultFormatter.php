<?php

namespace Drupal\color_picker\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'color_default' formatter.
 *
 * @FieldFormatter(
 *   id = "color_default",
 *   label = @Translation("Color display"),
 *   field_types = {
 *     "color"
 *   }
 * )
 */
class colorDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      if (!empty($item->value)) {
        $elements[$delta] = [
          '#markup' => '<div style="display: flex; align-items: center; gap: 10px;">
                          <div style="width:20px; height:20px; background-color:' . $item->value . ';"></div>
                          <span>' . $item->value . '</span>
                        </div>',
        ];
      }
    }

    return $elements;
  }

}
