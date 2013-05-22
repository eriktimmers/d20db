<?php

class Application_Model_DbTable_Class extends Zend_Db_Table_Abstract
{

    protected $_name = 'class';
    protected $_primary = 'cls_id';
    
    protected $_referenceMap = array (
        'World' => array(
            'columns' => array('cls_world'),
            'refTableClass' => 'Application_Model_DbTable_World',
            'refColumns' => array('wrl_id')
        ),
        'Subclass' => array(
            'columns' => array('cls_subclass'),
            'refTableClass' => 'Application_Model_DbTable_Class',
            'refColumns' => array('cls_id')
        ),
        'Agregateclass' => array(
            'columns' => array('cls_aggregatedin'),
            'refTableClass' => 'Application_Model_DbTable_Class',
            'refColumns' => array('cls_id')
        )        
    );    
    
    
}

