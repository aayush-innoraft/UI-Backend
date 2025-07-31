<?php

namespace Drupal\testing_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\NodeInterface;

/**
 * Provides a form for user input.
 */

class CustomUserForm extends FormBase
{

    public function getFormId()
    {
        return 'testing_module_custom_user_form';
    }
    public  function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#required' => TRUE,
        ];

        $form['sur_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Surname'),
            '#required' => TRUE,
        ];
        $form['email'] =[
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#required' => TRUE,
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('click to submit'),
        ];
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $name = $form_state->getValue('name');
        $sur_name = $form_state->getValue('sur_name');
        $email = $form_state->getValue('email');
        $created = time();
        $id = 1;
        $connection = \Drupal::database();
        $connection->insert('testing')
          ->fields([

            'name'=> $name,
            'sur_name'=> $sur_name,
            'email'=> $email,
            'created' => $created
          ])
          ->execute();
          \Drupal::messenger()->addMessage($this->t('Data has been saved successfully.'));
    }
}
