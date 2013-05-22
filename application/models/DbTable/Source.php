<?php

class Application_Model_DbTable_Source extends Zend_Db_Table_Abstract
{

    protected $_name = 'source';
    protected $_primary = 'src_id';

    protected $_referenceMap = array (
        'SourceType' => array(
            'columns' => array('src_type'),
            'refTableClass' => 'Application_Model_DbTable_SourceType',
            'refColumns' => array('sct_id')
        ),
        'Gamesystem' => array(
            'columns' => array('src_system'),
            'refTableClass' => 'Application_Model_DbTable_Gamesystem',
            'refColumns' => array('sys_id')
        ),
        'World' => array(
            'columns' => array('src_world'),
            'refTableClass' => 'Application_Model_DbTable_World',
            'refColumns' => array('wrl_id')
        )        
    );
    
}

