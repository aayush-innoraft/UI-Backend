<?php

namespace Drupal\movie\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\movie\Event\MovieBudgetCompareEvent;

/**
 *
 */
class MovieBudgetCompareSubscriber implements EventSubscriberInterface {

  protected ConfigFactoryInterface $configFactory;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   *
   */
  public static function getSubscribedEvents(): array {
    return [
      MovieBudgetCompareEvent::NAME => 'onMovieBudgetCompare',
    ];
  }

  /**
   *
   */
  public function onMovieBudgetCompare(MovieBudgetCompareEvent $event) {
    $node = $event->getNode();

    $budget = (float) ($this->configFactory->get('movie.settings')->get('budget'));
    $price = (float) ($node->get('field_movie_price')->value);

    \Drupal::logger('movie')->notice("Movie budget check: Price = $price, Budget = $budget");

    $message = '';
    if ($price < $budget) {
      $message = 'The movie is under budget';
    }
    elseif ($price > $budget) {
      $message = 'The movie is over budget';
    }
    else {
      $message = 'The movie is within budget';
    }

    \Drupal::messenger()->addMessage($message);
  }

}
