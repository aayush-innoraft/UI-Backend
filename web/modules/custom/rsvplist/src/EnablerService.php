<?php

namespace Drupal\rsvplist;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\node\NodeInterface;

class EnablerService {

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  public function isEnabled(NodeInterface $node) {
    $allowed_types = $this->configFactory->get('rsvplist.settings')->get('allowed_types');
    return in_array($node->getType(), $allowed_types);
  }

}
