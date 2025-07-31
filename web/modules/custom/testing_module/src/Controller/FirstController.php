<?php

namespace Drupal\testing_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\core\StringTranslation\StringTranslationTrait;   
class FirstController extends ControllerBase{
    public function firstcontent(){
        return[
            '#markup'=> $this->t('first controller function')
        ];
    }
    public function dynamicContent($name_1 , $name_2){
        return[
            '#markup'=> $this->t('Greetings Mr @name1 and Mr. @name2' , ['@name1'=> $name_1, '@name2' => $name_2])
        ];
    }
}