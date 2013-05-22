<?php

class Application_Model_DbTable_Pantheon extends Zend_Db_Table_Abstract
{

    protected $_name = 'deity_pantheon';
    protected $_primary = 'panth_id';

    protected $_dependentTables = array('Application_Model_DbTable_Deity');    
    
}

