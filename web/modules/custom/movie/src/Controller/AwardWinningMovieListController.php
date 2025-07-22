<?php
namespace Drupal\movie\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Provides a list controller for Award Winning Movie config entity.
 */
class AwardWinningMovieListController extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Movie Title');
    $header['year'] = $this->t('Year');
    $header['movie'] = $this->t('Movie ID');
    $header += parent::buildHeader();
    return $header;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\movie\Entity\AwardWinningMovie $entity */
    $row['label'] = $entity->label();
    $row['year'] = $entity->year ?? 'N/A';
    $row['movie'] = $entity->movie ?? 'N/A';

    $row += parent::buildRow($entity);
    return $row;
  }
}
