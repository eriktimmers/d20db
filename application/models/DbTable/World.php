<?php

class Application_Model_DbTable_World extends Zend_Db_Table_Abstract
{

    protected $_name = 'world';
    protected $_primary = 'wrl_id';

    protected $_dependentTables = array('Application_Model_DbTable_Source',
                                        'Application_Model_DbTable_Class',
                                        'Application_Model_DbTable_Spell'
                                       );    
    
}

