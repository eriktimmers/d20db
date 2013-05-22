<?php

class Application_Model_DbTable_Gamesystem extends Zend_Db_Table_Abstract
{

    protected $_name = 'systeem';
    protected $_primary = 'sys_id';

    protected $_dependentTables = array('Application_Model_DbTable_Source', 
                                        'Application_Model_DbTable_Spell');    
    
}

