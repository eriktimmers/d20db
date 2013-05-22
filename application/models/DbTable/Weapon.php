<?php

class Application_Model_DbTable_Weapon extends Zend_Db_Table_Abstract
{

    protected $_name = 'equipmentweapon';
    protected $_primary = 'wea_id'; 
    protected $_sequence = true;
    
    protected $_referenceMap = array (
        'Damagetype' => array(
            'columns' => array('wea_damagetype'),
            'refTableClass' => 'Application_Model_DbTable_WeaponDamagetype',
            'refColumns' => array('wdt_id')
        )   
    );     

}

