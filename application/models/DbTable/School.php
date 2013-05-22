<?php

class Application_Model_DbTable_School extends Zend_Db_Table_Abstract
{

    protected $_name = 'school';
    protected $_primary = 'sch_id';
    protected $_sequence = true;
    
    protected $_dependentTables = array('Application_Model_DbTable_Subschool');

}

