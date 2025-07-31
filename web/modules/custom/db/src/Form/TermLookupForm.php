<?php

namespace Drupal\db\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;

class TermLookupForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'term_lookup_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['term_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enter taxonomy term name (case-sensitive)'),
            '#required' => TRUE,
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Lookup Term'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $term_name = $form_state->getValue('term_name');

        // 1. Load taxonomy term by name (case-sensitive)
        $terms = \Drupal::entityTypeManager()
            ->getStorage('taxonomy_term')
            ->loadByProperties(['name' => $term_name]);

        if (empty($terms)) {
            \Drupal::messenger()->addMessage("❌ Term '$term_name' not found.", 'error');
            return;
        }

        /** @var \Drupal\taxonomy\Entity\Term $term */
        $term = reset($terms);
        $tid = $term->id();
        $uuid = $term->uuid();

        // 2. Display Term ID and UUID
        \Drupal::messenger()->addMessage("🆔 Term ID: $tid");
        \Drupal::messenger()->addMessage("🔑 Term UUID: $uuid");

        // 3. Query nodes using this term
        // ⚠️ Replace 'field_tags' with the actual taxonomy reference field name on your nodes
        $query = \Drupal::entityQuery('node')
            ->accessCheck(TRUE)
            ->condition('status', 1)
            ->condition('field_taggs', $tid);  // Change this to your actual taxonomy field

        $nids = $query->execute();

        if (empty($nids)) {
            \Drupal::messenger()->addMessage("ℹ️ No nodes found using this term.");
            return;
        }

        $nodes = Node::loadMultiple($nids);
        foreach ($nodes as $node) {
            $title = $node->label();
            $url = $node->toUrl()->toString();
            \Drupal::messenger()->addMessage("📄 $title → $url");
        }
    }
}
