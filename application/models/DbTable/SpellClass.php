<?php

class Application_Model_DbTable_SpellClass extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'spell_class';
    protected $_primary = 'spcl_id';
    protected $_sequence = true;    
    
    protected $_parentlink = 'spcl_class';
    protected $_childlink = 'spcl_spell';
    protected $_secundary = 'spcl_level';    
    protected $_linkedId = 'cls_id';
    
    protected $_referenceMap = array (
        'Spell' => array(
            'columns' => array('spcl_spell'),
            'refTableClass' => 'Application_Model_DbTable_Spell',
            'refColumns' => array('spl_id')
        ),
        'Class' => array(
            'columns' => array('spcl_class'),
            'refTableClass' => 'Application_Model_DbTable_Class',
            'refColumns' => array('cls_id')
        )
    ); 
    

}

