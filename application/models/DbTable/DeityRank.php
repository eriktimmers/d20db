<?php

class Application_Model_DbTable_DeityRank extends Zend_Db_Table_Abstract
{

    protected $_name = 'deity_rank';
    protected $_primary = 'dra_id';

    protected $_dependentTables = array('Application_Model_DbTable_Deity');    
    
}

