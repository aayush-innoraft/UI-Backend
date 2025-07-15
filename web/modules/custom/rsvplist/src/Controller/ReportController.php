<?php

/**
 * @file
 * Provides site administrators with a list of all RSVP signups.
 */

namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class ReportController extends ControllerBase
{

    /**
     * Gets and returns all RSVPs for all nodes.
     * These are returned as an associative array containing the
     * username, node title, and RSVP email.
     *
     * @return array|null
     */
    protected function load()
    {
        try {
            $database = \Drupal::database();

            // Base select query on rsvplist table with alias 'r'
            $query = $database->select('rsvplist', 'r');

            // Join users table to get the username
            $query->join('users_field_data', 'u', 'r.uid = u.uid');

            // Join node table to get event title
            $query->join('node_field_data', 'n', 'r.nid = n.nid');

            // Select the required fields from the joined tables
            $query->addField('u', 'name', 'username');
            $query->addField('n', 'title');
            $query->addField('r', 'mail');

            // Fetch the results as an array of associative arrays
            $entries = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);

            return $entries;
        } catch (\Exception $e) {
            \Drupal::messenger()->addError($this->t('Unable to access the database. Please try again.'));
            return NULL;
        }
    }
    public function report()
    {
        $content = [];
        $content['message'] = [
            '#markup' => $this->t('Below is the list of all RSVP entries.'),
        ];

        $headers = [
            $this->t('Username'),
            $this->t('Event'),
            $this->t('Email'),
        ];

        $entries = $this->load();
        $rows = [];

        if (!empty($entries)) {
            foreach ($entries as $entry) {
                $rows[] = [
                    $entry['username'],
                    $entry['title'],
                    $entry['mail'],
                ];
            }
        }

        $content['table'] = [
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $rows,
            '#empty' => $this->t('No RSVP entries available.'),
        ];

        // Disable caching to always show latest
        $content['#cache']['max-age'] = 0;

        return $content;
    }
}
