<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Exception;

class CustomForm extends FormBase
{

  public function getFormId()
  {
    return 'custom_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'custom_module.admin_settings',
    ];
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node ? $node->id() : 0;

    $form['FullName'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#size' => 50,
      '#description' => $this->t('Enter your full name'),
      '#required' => TRUE,
    ];

    $form['PhoneNumber'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#description' => $this->t('Enter your phone number'),
      '#required' => TRUE,
    ];

    $form['EmailID'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Enter your email'),
      '#required' => TRUE,
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#required' => TRUE,
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
    ];

    $form['Submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Click To Submit'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('EmailID');
    $phone_number = $form_state->getValue('PhoneNumber');

    // 1. RFC format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('EmailID', message: $this->t('The email should be in a valid RFC format.'));
      return;
    }

    // 2. Public domain check
    $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'live.com'];
    $domain = strtolower(substr(strrchr($email, "@"), 1));

    if (!in_array($domain, $public_domains)) {
      $form_state->setErrorByName('EmailID', $this->t('Only public domain emails are allowed (e.g., Gmail, Yahoo, Outlook).'));
      return;
    }
    // 3. Must end with .com
    if (substr($domain, -4) !== '.com') {
      $form_state->setErrorByName('EmailID', $this->t('Only .com email addresses are allowed.'));
    }

    // 4. Phone number validation
    if (!preg_match('/^(\+91|0)?[6-9]\d{9}$/', $phone_number)) {
      $form_state->setErrorByName('PhoneNumber', $this->t('Please enter a valid Indian phone number.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // $this->messenger()->addMessage($this->t('Form submitted!'));

    try {
      $fullname = $form_state->getValue('FullName');
      $phone_number = $form_state->getValue('PhoneNumber');
      $email  = $form_state->getValue('EmailID');
      $gender = $form_state->getValue('gender');
      $querry = \Drupal::database()->insert('custom_module');
      $querry->fields([
        'full_name',
        'phone_number',
        'email',
        'gender'
      ]);
      $querry->values([
        $fullname,
        $phone_number,
        $email,
        $gender
      ]);
      $querry->execute();
      \Drupal::messenger()->addMessage($this->t('thanks for form submision'));
    } catch (Exception $e) {
      \Drupal::messenger()->addMessage($this->t('form not filled try again'));
    }
  }
}
