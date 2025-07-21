<?php

declare(strict_types=1);

namespace Drupal\otp_genrator\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'otp_genrator_media_default' formatter.
 *
 * @FieldFormatter(
 *   id = "otp_genrator_media_default",
 *   label = @Translation("Default"),
 *   field_types = {"otp_genrator_media"},
 * )
 */
final class MediaDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->enter_name) {
        $element[$delta]['enter_name'] = [
          '#type' => 'item',
          '#title' => $this->t('enter-name'),
          '#markup' => $item->enter_name,
        ];
      }

      if ($item->email) {
        $element[$delta]['email'] = [
          '#type' => 'item',
          '#title' => $this->t('email'),
          'content' => [
            '#type' => 'link',
            '#title' => $item->email,
            '#url' => Url::fromUri('mailto:' . $item->email),
          ],
        ];
      }

      $element[$delta]['media'] = [
        '#type' => 'item',
        '#title' => $this->t('media'),
        '#markup' => $item->media ? $this->t('Yes') : $this->t('No'),
      ];

      if ($item->image) {
        $element[$delta]['image'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 4'),
          'content' => [
            '#type' => 'link',
            '#title' => $item->image,
            '#url' => Url::fromUri('tel:' . rawurlencode(preg_replace('/\s+/', '', $item->image))),
          ],
        ];
      }

    }

    return $element;
  }

}
