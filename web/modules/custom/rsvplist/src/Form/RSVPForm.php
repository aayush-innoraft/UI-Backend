<?php

/**
 * @file
 * A form to collect email address for RSVP.
 */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RSVPForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'rsvplist_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node ? $node->id() : 0;
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Email address."),
      '#size' => 25,
      '#description' => $this->t("We will send updates to the email you provided."),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("RSVP"),
    ];

    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];

    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('email');
    if (!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('It appears that %mail is not valid. Please try again.', ['%mail' => $email]));
    }
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // $submitted_email = $form_state->getValue('email');
    // $this->messenger()->addMessage(
    //   $this->t("The form is working! You entered @entry.", ['@entry' => $submitted_email])
    // );

    try {
      //get user id 
      $uid = \Drupal::currentUser()->id();
      $nid = $form_state->getValue('nid');
      $email = $form_state->getValue('email');
      $current_time = \Drupal::time()->getRequestTime();

      // now we are inserting these queries to the database

      $querry = \Drupal::database()->insert('rsvplist');
      $querry->fields([
        'uid',
        'nid',
        'mail',
        'created'

      ]);
      $querry->values([
        $uid,
        $nid,
        $email,
        $current_time,
      ]);
    
      //execute database querry .
      $querry->execute();
      \Drupal::messenger()->addMessage('thank for email submission');

    } catch (\Exception $e) {
      \Drupal::messenger()->addMessage('unable to insert into table rsvp_list');
    }
  }
}
