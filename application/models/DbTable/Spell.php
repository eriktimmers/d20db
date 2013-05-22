<?php

class Application_Model_DbTable_Spell extends Zend_Db_Table_Abstract
{

    protected $_name = 'spell';
    protected $_primary = 'spl_id'; 
    protected $_sequence = true;
    
    protected $_referenceMap = array (
        'World' => array(
            'columns' => array('spl_world'),
            'refTableClass' => 'Application_Model_DbTable_World',
            'refColumns' => array('wrl_id')
        ),
        'Favouredclass' => array(
            'columns' => array('spl_systeem'),
            'refTableClass' => 'Application_Model_DbTable_Gamesystem',
            'refColumns' => array('sys_id')
        )        
    );    

}

