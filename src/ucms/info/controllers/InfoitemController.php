<?php

namespace ucms\info\controllers;

class InfoitemController extends \ultimo\mvc\Controller {
  
  /**
   * @var ucms\info\managers\InfoManager
   */
  protected $manager;
  
  protected function init() {
    $this->manager = $this->module->getPlugin('uorm')->getManager();
  }
  
  public function actionIndex() {
    $this->view->infoitems = $this->manager->Infoitem->orderByIndex()->all(true);
  }
  
  public function actionRead() {
    $id = $this->request->getParam('id');

    $infoitem = $this->manager->Infoitem->withImages()->getById($id);

    if ($infoitem === null) {
            throw new \ultimo\mvc\exceptions\DispatchException("Infoitem with id '{$id}' does not exist.", 404);
    }
    $this->view->infoitem = $infoitem;
  }

  
  public function actionCreate() {
    $categories = $this->manager->Category->getAsKeyValue();
    
    $form = $this->module->getPlugin('formBroker')->createForm(
      'infoitem\CreateForm', $this->request->getParam('form', array()),
      array('categoryIds' => array_keys($categories))
    );
    
    if ($this->request->isPost()){
      if ($form->validate()) {
        $infoitem = $this->manager->Infoitem->create();
        $infoitem->category_id = $form['category_id'];
        $infoitem->title = $form['title'];
        $infoitem->body = $form['body'];
        $infoitem->save();
        
        return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'id' => $infoitem->id));
      }
    }
    
    $this->view->categories = $categories;
    $this->view->form = $form;
  }
  
  public function actionMove() {
    $id = $this->request->getParam('id');
    $infoitem = $this->manager->Infoitem->get($id);
    
    if ($infoitem === null) {
      throw new \ultimo\mvc\exceptions\DispatchException("Infoitem with id '{$id}' does not exist.", 404);
    }

    $infoitem->move($this->request->getParam('count', 0));
    
    return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'controller' => 'category', 'id' => $infoitem['category_id']));
  }
  
  public function actionUpdate() {
    $categories = $this->manager->Category->getAsKeyValue();
    
    $id = $this->request->getParam('id');

    $form = $this->module->getPlugin('formBroker')->createForm(
      'infoitem\UpdateForm', $this->request->getParam('form', array()),
      array('categoryIds' => array_keys($categories))
    );

    if ($this->request->isPost()) {
      if ($form->validate()) {
        $infoitem = $this->manager->Infoitem->get($id);
        $infoitem->category_id = $form['category_id'];
        $infoitem->title = $form['title'];
        $infoitem->body = $form['body'];
        $infoitem->save();
      
        return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'id' => $infoitem->id));
      }
    } else {
      $infoitem = $this->manager->Infoitem->get($id);
      
      if ($infoitem === null) {
        throw new \ultimo\mvc\exceptions\DispatchException("Infoitem with id '{$id}' does not exist.", 404);
      }
      
      $form->fromArray($infoitem->toArray());
    }
    
    $this->view->images = $this->module->getPlugin('helper')
                         ->getHelper('Visualiser')
                         ->getImages('InfoitemImage', $id);
    $this->view->imageForm = $this->module->getPlugin('formBroker')->createForm(
      'image\CreateForm'
    );
    
    $this->view->id = $id;
    $this->view->form = $form;
    $this->view->categories = $categories;
  }
  
  public function actionDelete() {
    $id = $this->request->getParam('id');
    $infoItem = $this->manager->Infoitem->get($id);
    
    if ($infoItem === null) {
      throw new \ultimo\mvc\exceptions\DispatchException("Infoitem with id '{$id}' does not exist.", 404);
    }
    
    $infoItem->delete();
    
    return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'controller' => 'category', 'id' => $infoItem['category_id']));
  }
}