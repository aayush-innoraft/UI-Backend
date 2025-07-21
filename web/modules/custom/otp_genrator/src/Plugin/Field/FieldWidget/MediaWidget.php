<?php

declare(strict_types=1);

namespace Drupal\otp_genrator\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'otp_genrator_media' field widget.
 *
 * @FieldWidget(
 *   id = "otp_genrator_media",
 *   label = @Translation("media"),
 *   field_types = {"otp_genrator_media"},
 * )
 */
final class MediaWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['enter_name'] = [
      '#type' => 'textarea',
      '#title' => $this->t('enter-name'),
      '#default_value' => $items[$delta]->enter_name ?? NULL,
    ];

    $element['email'] = [
      '#type' => 'email',
      '#title' => $this->t('email'),
      '#default_value' => $items[$delta]->email ?? NULL,
    ];

    $element['media'] = [
      '#type' => 'media',
      '#title' => $this->t('media'),
      '#default_value' => $items[$delta]->media ?? NULL,
    ];

    $element['image'] = [
      '#type' => 'media',
      '#title' => $this->t('Value 4'),
      '#default_value' => $items[$delta]->image ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'otp-genrator-media-elements';
    $element['#attached']['library'][] = 'otp_genrator/otp_genrator_media';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $error, array $form, FormStateInterface $form_state): array|bool {
    $element = parent::errorElement($element, $error, $form, $form_state);
    if ($element === FALSE) {
      return FALSE;
    }
    $error_property = explode('.', $error->getPropertyPath())[1];
    return $element[$error_property];
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state): array {
    foreach ($values as $delta => $value) {
      if ($value['enter_name'] === '') {
        $values[$delta]['enter_name'] = NULL;
      }
      if ($value['email'] === '') {
        $values[$delta]['email'] = NULL;
      }
      if ($value['media'] === '') {
        $values[$delta]['media'] = NULL;
      }
      if ($value['image'] === '') {
        $values[$delta]['image'] = NULL;
      }
    }
    return $values;
  }

}
