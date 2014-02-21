<?php

namespace ucms\info\forms\infoitem;

class ModifyForm extends \ultimo\form\Form {
  
  protected function init() {
    $this->appendValidator('category_id', 'InArray', array($this->getConfig('categoryIds')));
    $this->appendValidator('title', 'StringLength', array(1, 255));
    $this->appendValidator('body', 'NotEmpty');
  }
}