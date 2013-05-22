<?php

class Application_Model_DbTable_SpellSpellDescriptor extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'spell_descriptor';
    protected $_primary = 'spdc_id';
    protected $_sequence = true;      

    protected $_parentlink = 'spdc_descriptor';
    protected $_childlink = 'spdc_spell'; 
    protected $_linkedId = 'dcp_id';    
    
    protected $_referenceMap = array (
        'Descriptor' => array(
            'columns' => array('spdc_descriptor'),
            'refTableClass' => 'Application_Model_DbTable_SpellDescriptor',
            'refColumns' => array('dcp_id')
        ),
        'Spell' => array(
            'columns' => array('spdc_spell'),
            'refTableClass' => 'Application_Model_DbTable_Spell',
            'refColumns' => array('spl_id')
        )
    );   

}

	