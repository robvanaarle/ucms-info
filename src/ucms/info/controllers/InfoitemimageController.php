<?php

namespace ucms\info\controllers;

class InfoitemimageController extends \ucms\visualiser\controllers\ImageController {
  protected function getVisualised($visualised_id) {
    $manager = $this->module->getPlugin('uorm')->getManager();
    return $manager->Infoitem->get($visualised_id);
  }
}