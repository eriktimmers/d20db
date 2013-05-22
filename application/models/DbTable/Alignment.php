<?php

class Application_Model_DbTable_Alignment extends Zend_Db_Table_Abstract
{

    protected $_name = 'alignment';
    protected $_primary = 'al_id';    
    
    protected $_dependentTables = array('Application_Model_DbTable_Deity');


}

