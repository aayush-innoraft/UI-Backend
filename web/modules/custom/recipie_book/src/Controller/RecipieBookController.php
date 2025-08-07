<?php
// recipie_book/src/Controller/RecipieBookController.php

namespace Drupal\recipie_book\Controller;
use Drupal\node\NodeInterface;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the Recipe Book module.
 */
class RecipieBookController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new RecipeBookController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
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
   * Builds the recipe listing page.
   *
   * @return array
   * A render array for the recipe listing page.
   */
public function listpage() {
  $node_storage = $this->entityTypeManager->getStorage('node');

  $query = $node_storage->getQuery()
    ->condition('status', 1)
    ->condition('type', 'recipie')
    ->sort('title', 'ASC')
    ->accessCheck(TRUE);

  $nids = $query->execute();
  $recipes = $node_storage->loadMultiple($nids);

  $rows = [];

 foreach ($recipes as $recipe) {
  if ($recipe instanceof NodeInterface) {
    $rows[] = [
      'data' => [
        $recipe->toLink(), // Title as a link.
        \Drupal::service('date.formatter')->format($recipe->getCreatedTime(), 'short'),
        $recipe->getOwner()->getDisplayName(),
      ],
    ];
  }
}


  $header = [
    $this->t('Recipe Title'),
    $this->t('Created Date'),
    $this->t('Author'),
  ];

  return [
    '#type' => 'container',
    'heading' => [
      '#markup' => '<h2>Here are all of our delicious recipes!</h2>',
    ],
    'table' => [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No recipes available.'),
    ],
  ];
}



}