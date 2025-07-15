<?php

namespace Drupal\custom_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Link;
use Drupal\Core\Url;

class CustomDataController extends ControllerBase
{

  public function showData()
  {
    $header = [
      ['data' => $this->t('Full Name')],
      ['data' => $this->t('Phone Number')],
      ['data' => $this->t('Email')],
      ['data' => $this->t('Gender')],
    ];

    // If current user is admin, add the "Operations" column
    if ($this->currentUser()->hasPermission('administer site configuration')) {
      $header[] = ['data' => $this->t('Operations')];
    }


    $rows = [];
    $connection = Database::getConnection();
    $result = $connection->select('custom_module', 'cm')
      ->fields('cm', ['full_name', 'phone_number', 'email', 'gender'])
      ->execute();

    foreach ($result as $record) {
      // $delete_link = '';

      if ($this->currentUser()->hasPermission('administer site configuration')) {
        $delete_url = Url::fromRoute('custom_module.delete_data', ['email' => base64_encode($record->email)]);
        $delete_link = Link::fromTextAndUrl('Delete', $delete_url)->toRenderable();
        $delete_link['#attributes'] = ['class' => ['button', 'button--danger']];
      }

      $rows[] = [
        'data' => [
          ['data' => $record->full_name],
          ['data' => $record->phone_number],
          ['data' => $record->email],
          ['data' => $record->gender],
          ['data' => $delete_link],
        ],
      ];
    }


    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No records found.'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  public function deleteData($email)
  {
    // Decode the email back from URL-safe format
    $decoded_email = base64_decode($email);

    $connection = Database::getConnection();
    $deleted = $connection->delete('custom_module')
      ->condition('email', $decoded_email)
      ->execute();

    if ($deleted) {
      $this->messenger()->addMessage($this->t('Record with email %email has been deleted.', ['%email' => $decoded_email]));
    } else {
      $this->messenger()->addError($this->t('Record with email %email was not found.', ['%email' => $decoded_email]));
    }

    return $this->redirect('custom_module.show_data');
  }
}





