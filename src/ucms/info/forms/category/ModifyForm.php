<?php

namespace ucms\info\forms\category;

class ModifyForm extends \ultimo\form\Form {
  
  protected function init() {
    $this->appendValidator('name', 'StringLength', array(1, 255));
  }
}