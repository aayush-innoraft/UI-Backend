<?php

namespace Drupal\db\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class EventDashboardController extends ControllerBase
{

  public function dashboard()
  {
    $connection = Database::getConnection();

    // 🗓️ Events per Year
    $query1 = $connection->select('node__field_event_date', 'd');
    $query1->addExpression('COUNT(*)', 'count');
    $query1->addExpression("YEAR(STR_TO_DATE(d.field_event_date_value, '%Y-%m-%d'))", 'year');
    $query1->groupBy('year');
    $results1 = $query1->execute()->fetchAll();

    // 📅 Events per Quarter
    $query2 = $connection->select('node__field_event_date', 'd');
    $query2->addExpression('COUNT(*)', 'count');
    $query2->addExpression("CONCAT(YEAR(STR_TO_DATE(d.field_event_date_value, '%Y-%m-%d')), '-Q', QUARTER(STR_TO_DATE(d.field_event_date_value, '%Y-%m-%d')))", 'quarter');
    $query2->groupBy('quarter');
    $results2 = $query2->execute()->fetchAll();

    // 🏷️ Events per Type
    $query3 = $connection->select('node__field_event_type', 't');
    $query3->addField('t', 'field_event_type_value', 'event_type');
    $query3->addExpression('COUNT(*)', 'count');
    $query3->groupBy('event_type');
    $results3 = $query3->execute()->fetchAll();

    // 🖥️ Render Output
    $build = [
      '#markup' => '<h2>Events Per Year</h2><ul>',
    ];
    foreach ($results1 as $row) {
      $build['#markup'] .= "<li>{$row->year}: {$row->count}</li>";
    }
    $build['#markup'] .= '</ul><h2>Events Per Quarter</h2><ul>';
    foreach ($results2 as $row) {
      $build['#markup'] .= "<li>{$row->quarter}: {$row->count}</li>";
    }
    $build['#markup'] .= '</ul><h2>Events Per Type</h2><ul>';
    foreach ($results3 as $row) {
      $build['#markup'] .= "<li>{$row->event_type}: {$row->count}</li>";
    }
    $build['#markup'] .= '</ul>';

    return $build;
  }
}
