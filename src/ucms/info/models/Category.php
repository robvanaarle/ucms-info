<?php

namespace ucms\info\models;

class Category extends \ultimo\orm\Model {
  public $id;
  public $name;
  
  static protected $fields = array('id', 'name');
  static protected $primaryKey = array('id');
  static protected $autoIncrementField = 'id';
  static protected $relations = array(
    'infoitems' => array('Infoitem', array('id' => 'category_id'), self::ONE_TO_MANY)
  );
  static protected $fetchers = array('getAsKeyValue');
  
  static public function getAsKeyValue($s) {
    $result = array();
    foreach ($s->all(true) as $category) {
      $result[$category['id']] = $category['name'];
    }
    return $result;
  }
}