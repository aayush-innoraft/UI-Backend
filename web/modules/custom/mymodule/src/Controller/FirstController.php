<?php
   
/**
 * @file
 * Generates markup to display!
 */
 
namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;

class FirstController extends ControllerBase {
 
  public function SimpleContent() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello Aayush'),
    ];
  }
  public function variableContent($name_1 , $name_2){
    return[
        '#type' => 'markup',
        '#markup' =>$this->t('@name1 and @name2 say hello to you.
        ' , ['@name1'=> $name_1 , '@name2' => $name_2]),
    ];
  }
}
