<?php

namespace Drupal\movie\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Award Winning Movie config entity.
 *
 * @ConfigEntityType(
 *   id = "award_winning_movie",
 *   label = @Translation("Award Winning Movie"),
 *   handlers = {
 *     "list_builder" = "Drupal\movie\Controller\AwardWinningMovieListController",
 *     "form" = {
 *       "add" = "Drupal\movie\Form\AwardWinningMovieForm",
 *       "edit" = "Drupal\movie\Form\AwardWinningMovieForm",
 *       "delete" = "Drupal\movie\Form\AwardWinningMovieDeleteForm"
 *     }
 *   },
 *   config_prefix = "award_winning_movie",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "add-form" = "/admin/config/movie/award/add",
 *     "edit-form" = "/admin/config/movie/award/{award_winning_movie}/edit",
 *     "delete-form" = "/admin/config/movie/award/{award_winning_movie}/delete",
 *     "collection" = "/admin/config/movie/award"
 *   }
 * )
 */
class AwardWinningMovie extends ConfigEntityBase {
  /**
   * @var string */
  public $id;

  /**
   * @var string */
  public $label;

  /**
   * @var int */
  public $year;

  /**
   * @var string */
  public $movie;

}
