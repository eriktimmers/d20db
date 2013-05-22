<?php

class Application_Model_DbTable_Race extends Zend_Db_Table_Abstract
{

    protected $_name = 'race';
    protected $_primary = 'rce_id'; 
    protected $_sequence = true;

    protected $_referenceMap = array (
        'World' => array(
            'columns' => array('rce_world'),
            'refTableClass' => 'Application_Model_DbTable_World',
            'refColumns' => array('wrl_id')
        ),
        'Favouredclass' => array(
            'columns' => array('rce_favouredclass'),
            'refTableClass' => 'Application_Model_DbTable_Class',
            'refColumns' => array('cls_id')
        ),   
        'Agregateclass' => array(
            'columns' => array('rce_vision'),
            'refTableClass' => 'Application_Model_DbTable_Vision',
            'refColumns' => array('vis_id')
        )        
    );    
    
}

