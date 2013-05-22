<?php

class Application_Model_DbTable_Subschool extends Zend_Db_Table_Abstract
{

    protected $_name = 'subschool';
    protected $_primary = 'subs_id';
    protected $_sequence = true;
    
    protected $_referenceMap = array (
        'School' => array(
            'columns' => array('subs_school'),
            'refTableClass' => 'Application_Model_DbTable_School',
            'refColumns' => array('sch_id')
        ));    
    

}

