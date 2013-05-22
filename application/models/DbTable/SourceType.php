<?php

class Application_Model_DbTable_SourceType extends Zend_Db_Table_Abstract
{

    protected $_name = 'sourcetype';
    protected $_primary = 'sct_id';  

    protected $_dependentTables = array('Application_Model_DbTable_Source');    
    
}

