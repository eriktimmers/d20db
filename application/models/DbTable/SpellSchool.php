<?php

class Application_Model_DbTable_SpellSchool extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'spell_school';
    protected $_primary = 'spsc_id';
    protected $_sequence = true;      

    protected $_parentlink = 'spsc_subschool';
    protected $_childlink = 'spsc_spell'; 
    protected $_linkedId = 'subs_id';    
    
    protected $_referenceMap = array (
        'School' => array(
            'columns' => array('spsc_subschool'),
            'refTableClass' => 'Application_Model_DbTable_Subschool',
            'refColumns' => array('subs_id')
        ),
        'Spell' => array(
            'columns' => array('spsc_spell'),
            'refTableClass' => 'Application_Model_DbTable_Spell',
            'refColumns' => array('spl_id')
        )
    );     

}

