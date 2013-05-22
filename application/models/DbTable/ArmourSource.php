<?php

class Application_Model_DbTable_ArmourSource extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'equipmentarmour_source';
    protected $_primary = 'arso_id';
    protected $_sequence = true; 
    
    protected $_parentlink = 'arso_source';
    protected $_childlink = 'arso_armour';
    protected $_secundary = 'arso_page'; 
    protected $_linkedId = 'src_id';

    protected $_referenceMap = array (
        'Armour' => array(
            'columns' => array('arso_armour'),
            'refTableClass' => 'Application_Model_DbTable_Armour',
            'refColumns' => array('arm_id')
        ),
        'Source' => array(
            'columns' => array('arso_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
        )
    );

}

