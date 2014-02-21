<?php

namespace ucms\info;

class Module extends \ultimo\mvc\Module implements \ultimo\security\mvc\AuthorizedModule {
  protected function init() {
    $this->setAbstract(true);
    $this->addPartial($this->application->getModule('ucms\visualiser'));
  }
  
  public function getAcl() {
    $acl = new \ultimo\security\Acl();
    $acl->addRole('info.guest');
    $acl->addRole('info.admin', array('info.guest'));
    
    $acl->allow('info.guest', array('infoitem.read'));
    $acl->allow('info.admin');
    return $acl;
  }
}