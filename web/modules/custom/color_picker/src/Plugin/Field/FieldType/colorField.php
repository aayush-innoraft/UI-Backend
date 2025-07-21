<?php

namespace Drupal\color_picker\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;


/**
 * Plugin implementation of the 'color' field type.
 *
 * @FieldType(
 *   id = "color",
 *   label = @Translation("Color"),
 *   description = @Translation("Stores a color code."),
 *   default_widget = "color_default",
 *   default_formatter = "color_default"
 * )
 */
class ColorField extends FieldItemBase {

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 7,  // stores hex code like #FFFFFF
        ],
      ],
    ];
  }

  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel('Color value');
    return $properties;
  }

}
