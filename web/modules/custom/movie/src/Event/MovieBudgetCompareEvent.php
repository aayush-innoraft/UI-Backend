<?php

namespace Drupal\movie\Event;

use symfony\Contracts\EventDispatcher\Event;
use Drupal\node\NodeInterface;

/**
 *
 */
class MovieBudgetCompareEvent extends Event {
  public const NAME = 'movie.movie_budget_compare';

  protected NodeInterface $node;

  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  /**
   *
   */
  public function getNode():NodeInterface {
    return $this->node;
  }

}
