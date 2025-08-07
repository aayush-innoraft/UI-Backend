<?php

declare(strict_types=1);

namespace Drupal\movie\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * all-movie style plugin.
 *
 * @ViewsStyle(
 *   id = "movie_all_movie",
 *   title = @Translation("all-movie"),
 *   help = @Translation("@todo Add help text here."),
 *   theme = "views_style_movie_all_movie",
 *   display_types = {"normal"},
 * )
 */
final class AllMovie extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  protected $usesRowClass = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions(): array {
    $options = parent::defineOptions();
    $options['wrapper_class'] = ['default' => 'item-list'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state): void {
    parent::buildOptionsForm($form, $form_state);
    $form['wrapper_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Wrapper class'),
      '#description' => $this->t('The class to provide on the wrapper, outside rows.'),
      '#default_value' => $this->options['wrapper_class'],
    ];
  }

}
