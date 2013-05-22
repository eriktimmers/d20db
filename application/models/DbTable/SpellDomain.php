<?php

class Application_Model_DbTable_SpellDomain extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'spell_domain';
    protected $_primary = 'spdm_id';
    protected $_sequence = true;    
    
    protected $_parentlink = 'spdm_domain';
    protected $_childlink = 'spdm_spell';
    protected $_secundary = 'spdm_level';    
    protected $_linkedId = 'dom_id';
    
    protected $_referenceMap = array (
        'Spell' => array(
            'columns' => array('spdm_spell'),
            'refTableClass' => 'Application_Model_DbTable_Spell',
            'refColumns' => array('spl_id')
        ),
        'Domain' => array(
            'columns' => array('spdm_domain'),
            'refTableClass' => 'Application_Model_DbTable_Domain',
            'refColumns' => array('dom_id')
        )
    );    

}

