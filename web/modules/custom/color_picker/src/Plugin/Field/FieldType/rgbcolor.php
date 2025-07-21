<?php

namespace Drupal\color_picker\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implements rgb color
 *
 * @FieldType(
 *   id = "rgb_color",
 *   label = @Translation("RGB Color"),
 *   description = @Translation("Stores RGB color as separate R, G, B values."),
 *   default_widget = "rgb_hex_widget",
 *   default_formatter = "rgb_static_text_formatter"
 * )
 */
class rgbcolor extends FieldItemBase {

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'r' => ['type' => 'int', 'unsigned' => TRUE, 'size' => 'tiny'],
        'g' => ['type' => 'int', 'unsigned' => TRUE, 'size' => 'tiny'],
        'b' => ['type' => 'int', 'unsigned' => TRUE, 'size' => 'tiny'],
      ],
    ];
  }

  public function isEmpty() {
    return $this->get('r')->getValue() === NULL &&
           $this->get('g')->getValue() === NULL &&
           $this->get('b')->getValue() === NULL;
  }

public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['r'] = DataDefinition::create('integer')->setLabel('Red');
    $properties['g'] = DataDefinition::create('integer')->setLabel('Green');
    $properties['b'] = DataDefinition::create('integer')->setLabel('Blue');
    return $properties;
}


}
