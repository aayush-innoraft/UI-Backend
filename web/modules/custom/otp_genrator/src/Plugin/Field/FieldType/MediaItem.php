<?php

declare(strict_types=1);

namespace Drupal\otp_genrator\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Render\Element\Email;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'otp_genrator_media' field type.
 *
 * @FieldType(
 *   id = "otp_genrator_media",
 *   label = @Translation("media"),
 *   description = @Translation("Some description."),
 *   default_widget = "otp_genrator_media",
 *   default_formatter = "otp_genrator_media_default",
 * )
 */
final class MediaItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->enter_name === NULL && $this->email === NULL && $this->media != 1 && $this->image === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['enter_name'] = DataDefinition::create('string')
      ->setLabel(t('enter-name'));
    $properties['email'] = DataDefinition::create('email')
      ->setLabel(t('email'));
    $properties['media'] = DataDefinition::create('boolean')
      ->setLabel(t('media'));
    $properties['image'] = DataDefinition::create('string')
      ->setLabel(t('Value 4'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    // @todo Add more constraints here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'enter_name' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'email' => [
        'type' => 'varchar',
        'length' => Email::EMAIL_MAX_LENGTH,
      ],
      'media' => [
        'type' => 'int',
        'size' => 'tiny',
      ],
      'image' => [
        'type' => 'varchar',
        'length' => 255,
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {

    $random = new Random();

    $values['enter_name'] = $random->paragraphs(5);

    $values['email'] = strtolower($random->name()) . '@example.com';

    $values['media'] = (bool) mt_rand(0, 1);

    $values['image'] = mt_rand(pow(10, 8), pow(10, 9) - 1);

    return $values;
  }

}
