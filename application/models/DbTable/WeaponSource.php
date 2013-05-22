<?php

class Application_Model_DbTable_WeaponSource extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'equipmentweapon_source';
    protected $_primary = 'weso_id';
    protected $_sequence = true; 
    
    protected $_parentlink = 'weso_source';
    protected $_childlink = 'weso_weapon';
    protected $_secundary = 'weso_page'; 
    protected $_linkedId = 'src_id';

    protected $_referenceMap = array (
        'Weapon' => array(
            'columns' => array('weso_weapon'),
            'refTableClass' => 'Application_Model_DbTable_Weapon',
            'refColumns' => array('wea_id')
        ),
        'Source' => array(
            'columns' => array('arso_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
        )
    );

}

