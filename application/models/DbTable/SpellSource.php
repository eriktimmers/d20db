<?php

class Application_Model_DbTable_SpellSource extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'spell_source';
    protected $_primary = 'spc_id';
    protected $_sequence = true;    
    
    protected $_parentlink = 'spc_source';
    protected $_childlink = 'spc_spell';
    protected $_secundary = 'spc_page';    
    protected $_linkedId = 'src_id';
    
    protected $_referenceMap = array (
        'Spell' => array(
            'columns' => array('spc_spell'),
            'refTableClass' => 'Application_Model_DbTable_Spell',
            'refColumns' => array('spl_id')
        ),
        'Source' => array(
            'columns' => array('spc_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
        )
    ); 
    

}

