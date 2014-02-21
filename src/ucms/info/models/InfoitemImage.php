<?php

namespace ucms\info\models;

class InfoitemImage extends \ucms\visualiser\models\Image {
  static protected $relations = array(
    'infoitem' => array('Infoitem', array('visualised_id' => 'id'), self::MANY_TO_ONE)
  );
}