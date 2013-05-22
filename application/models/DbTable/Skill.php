<?php

class Application_Model_DbTable_Skill extends Zend_Db_Table_Abstract
{

    protected $_name = 'skill';
    protected $_primary = 'skil_id';   
    protected $_sequence = true;

    protected $_referenceMap = array (
        'World' => array(
            'columns' => array('skil_world'),
            'refTableClass' => 'Application_Model_DbTable_World',
            'refColumns' => array('wrl_id')
        )        
    );  
}

