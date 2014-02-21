<?php

namespace ucms\info\facades\info;

class Infoitems extends \ultimo\mvc\Facade {
  
  /**
   * @var \ultimo\orm\manager
   */
  protected $manager;
  
  protected function init() {
    $this->manager = $this->module->getPlugin('uorm')->getManager();
  }
  
  public function getAll() {
    return $this->manager->Infoitem->withCategory()->orderByCategoryId()->orderByIndex()->all(true);
  }
  
  public function getByCategoryId($categoryId) {
    return $this->manager->Infoitem->fromCategory($categoryId)->orderByIndex()->all();
  }
}