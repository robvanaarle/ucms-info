<?php

namespace ucms\info\controllers;

class CategoryController extends \ultimo\mvc\Controller {
  
  /**
   * @var ucms\info\managers\InfoManager
   */
  protected $manager;
  
  protected function init() {
    $this->manager = $this->module->getPlugin('uorm')->getManager();
  }
  
  public function actionTest() {
    //$infoItems = $this->manager->Infoitem->published()->unread()->getAll();
    
//    echo "<pre>";
//    
//    
//    $result = $this->manager->Infoitem->byIdWithCategory(5)->first(true);
//    //$result = $this->manager->Infoitem->getAllSortedById();
//    echo "<br /><br />Result:<br />";
//    print_r($result);
//    echo "</pre>";
//    
    
//    $result = $this->manager->Infoitem->test(1)->first(true);
//    
//    echo "<br /><br />Result:<br /><pre>";
//    print_r($result);
//    echo "</pre>";
//            
//    echo "END2";
//    exit();
    
    
    $this->view->model = $this->manager->Infoitem->get(3);
    
//    echo "<pre>";
//    $infoitem->dump();
//    echo "</pre>";
//
//    //$infoitem->moveDown(1);
//    $infoitem->category_id = 2;
//    $infoitem->save();
//    
//    echo "<pre>";
//    $infoitem->dump();
//    echo "</pre>";
//    
//    echo "END";
//    exit();
  }
  
  public function actionIndex() {
    $this->view->categories = $this->manager->Category->all(true);
  }
  
  public function actionRead() {
    $id = $this->request->getParam('id');
    $category = $this->manager->Category->getById($id);
    
    if ($category === null) {
      throw new \ultimo\mvc\exceptions\DispatchException("Category with id '{$id}' does not exist.", 404);
    }
    
    $category['infoitems'] = $this->manager->Infoitem->fromCategory($id)->orderByIndex()->all(true);
    
    $this->view->category = $category;
  }
  
  public function actionCreate() {
    $form = $this->module->getPlugin('formBroker')->createForm(
      'category\CreateForm', $this->request->getParam('form', array())
    );
    
    if ($this->request->isPost()){
      if ($form->validate()) {
        $category = $this->manager->Category->create();
        $category->name = $form['name'];
        $category->save();
        
        return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'id' => $category->id));
      }
    }
    
    $this->view->form = $form;
  }
  
  public function actionUpdate() {
    $id = $this->request->getParam('id');

    $form = $this->module->getPlugin('formBroker')->createForm(
      'category\UpdateForm', $this->request->getParam('form', array())
    );

    if ($this->request->isPost()) {
      if ($form->validate()) {
        $category = $this->manager->Category->get($id);
        $category->name = $form['name'];
        $category->save();
      
        return $this->getPlugin('redirector')->redirect(array('action' => 'read', 'id' => $category->id));
      }
    } else {
      $category = $this->manager->Category->get($id);
      
      if ($category === null) {
        throw new \ultimo\mvc\exceptions\DispatchException("Category with id '{id}' does not exist.", 404);
      }
      
      $form->fromArray($category->toArray());
    }
    
    $this->view->id = $id;
    $this->view->form = $form;
  }
  
  public function actionDelete() {
    $id = $this->request->getParam('id');
    $this->manager->Category->get($id)->delete();
    return $this->getPlugin('redirector')->redirect(array('action' => 'index'));
  }
  
}