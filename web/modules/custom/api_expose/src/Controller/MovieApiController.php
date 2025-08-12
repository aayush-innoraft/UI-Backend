<?php

namespace Drupal\api_expose\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MovieApiController extends ControllerBase .
 */
class MovieApiController extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a MovieApiController object.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('entity_type.manager')
      );
  }

  /**
   * Returns all movie nodes.
   */
  public function getAllMovies() {
    $nodes = $this->entityTypeManager
      ->getStorage('node')
      ->loadByProperties(['type' => 'movie']);

    $data = [];
    foreach ($nodes as $node) {
      /** @var \Drupal\node\Entity\Node $node */
      $data[] = [
        'nid' => $node->id(),
        'title' => $node->getTitle(),
        'created' => date('Y-m-d', $node->getCreatedTime()),
      ];
    }

    return new JsonResponse($data);
  }

}
