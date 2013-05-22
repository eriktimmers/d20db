<?php

class Application_Model_DbTable_WeaponDamagetype extends Zend_Db_Table_Abstract
{

    protected $_name = 'weapon_damagetype';
    protected $_primary = 'wdt_id'; 
    protected $_sequence = true;
    
    protected $_dependentTables = array('Application_Model_DbTable_Weapon');    

}

