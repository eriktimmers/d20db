<?php

class Application_Model_WeaponService
{
    
    protected $table;    
    protected $prefix = 'wea_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Weapon();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();   
        $this->systemFilterObject = $session->filter;
    }
    
    public function all($aFilter=array())
    {
        
        $columnArray = array('wea_id', 'wea_name', 'wea_trainingcategory',
                             'wea_reachcategory', 'wea_reachsubcategory', 'wea_encumbrance',
                             'wea_dmg_m', 'wea_range_increment', 'wea_critical_range',
                             'wea_critical_multiplier'
                          );        
                
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('equipmentweapon', $columnArray);
        $query->joinLeft('equipmentweapon_source',   'weso_weapon = wea_id');
        $query->joinLeft('source',                   'weso_source = src_id'); 
        $query->joinLeft('weapon_damagetype',        'wea_damagetype = wdt_id', array('wdt_name'));
                      
        if (array_key_exists('filter', $aFilter)) {
            $query->where('wea_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }
        
        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('weso_source = ?', $aFilter['filter_source']);
        }     

        
        if (array_key_exists('filter_training', $aFilter) && 
                $aFilter['filter_training'] != '0' && 
                $aFilter['filter_training'] != null
                ) {
            $query->where('wea_trainingcategory = ?', $aFilter['filter_training']);
        }           

        if (array_key_exists('filter_reach', $aFilter) && 
                $aFilter['filter_reach'] != '0' && 
                $aFilter['filter_reach'] != null) {
            $query->where('wea_reachcategory = ?', $aFilter['filter_reach']);
        }      
        
        if (array_key_exists('filter_reachsub', $aFilter) && 
                $aFilter['filter_reachsub'] != '0' && 
                $aFilter['filter_reachsub'] != null) {
            $query->where('wea_reachsubcategory = ?', $aFilter['filter_reachsub']);
        }      
        
        if (array_key_exists('filter_encumbrance', $aFilter) && 
                $aFilter['filter_encumbrance'] != '0' && 
                $aFilter['filter_encumbrance'] != null) {
            $query->where('wea_encumbrance = ?', $aFilter['filter_encumbrance']);
        }             
        
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('wea_id');
        $query->order(array('wea_name ASC'));
        $query->limit(150);

        return $this->table->fetchAll($query)->toArray();
    }     
    

    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            $aSet['wdt_name'] = $oSet->findParentRow('Application_Model_DbTable_WeaponDamagetype')->wdt_name;
            $aSize = array('T' => 'Tiny', 'S' => 'Small', 'M' => 'Medium',
                           'L' => 'Large', 'H' => 'Huge');
            $aSet['wea_size_name'] = $aSize[$aSet['wea_size']];
            $aRof = $this->getListRateOfFire();
            $aSet['wea_rateoffire_name'] = $aRof[$aSet['wea_rateoffire']];
            
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('equipmentweapon_source', array('weso_page'));
            $query->join('source', 'src_id = weso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('weso_weapon = ?', (int)$aSet['wea_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['wea_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach((array)$aSet['wea_sources'] as $value) {
                $aSet['sourceform' . $i]['src_id'] = $value['src_id'];
                $aSet['sourceform' . $i]['weso_page'] = $value['weso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsourceforms'] = (count($aSet['wea_sources']) > 1 ? count($aSet['wea_sources']) : 1);
            
            return $aSet;
        }
        return false;
    }    
    
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("wea_id = ?", $id);
            $this->table->update($options, $where);
            
        } else {
            $this->table->insert($options);
            $id = $this->table->getAdapter()->lastInsertId();
        }
        
        
        $options = $form->getValues();
        
        foreach((array)$options as $key=>$value) {
            if (substr($key, 0, 10) == 'sourceform') {
                if ($value['src_id']) {
                    $aSourceforms[] = $value;
                }
            }
        }        
        
        $spellSource = new Application_Model_DbTable_WeaponSource();
        $spellSource->save($id, $aSourceforms);      
        return $id;
        
    }    
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("wea_id = ?", $id);
            $this->table->delete($where);
        }
        
    }            

    public function copy($id)
    {
        if ($id) {
            
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('equipmentweapon', 'wea_id', 
                array(
                    'null', "CONCAT(wea_name, ' (2)')", 'wea_trainingcategory', 
                    'wea_reachcategory', 'wea_reachsubcategory', 'wea_encumbrance', 
                    'wea_cost', 'wea_dmg_s', 'wea_dmg_m', 'wea_critical_range', 
                    'wea_critical_multiplier', 'wea_range_increment', 'wea_weight', 
                    'wea_damagetype', 'wea_progresslevel', 'wea_size', 'wea_rateoffire', 
                    'wea_magazine', 'wea_specialtype', 'wea_special', 'wea_img', 
                    'wea_description'
                    )
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
            $newId = $db->lastInsertId();    

            $sSql = Application_Model_Util::SqlForCopy('equipmentweapon_source', 'weso_weapon',
                array(
                    'null', "'" . $newId . "'", "weso_source", "weso_page" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
        }
        
    }    
    
    public function getListTrainingCategory()
    {
        $base = array('Simple' => 'Simple Weapon',
                      'Martial' => 'Martial Weapon',
                      'Exotic' => 'Exotic Weapon',
                      'Siege Engines' => 'Siege Engines');
        if ($this->systemFilterObject->isIncluded($this->systemFilterObject->MODERN)) {
            $base['Firearms'] = 'Personal Firearms';
            $base['Exotic Firearms'] = 'Exotic Firearms';
        }        
        return $base;
    }
    
    public function getListReachSubcategory()
    {
        $base = array('Reach' => 'Reach',
                      'Double' => 'Double',
                      'Thrown' => 'Thrown',
                      'Projectile' => 'Projectile',
                      'Ammunition' => 'Ammunition');
        
        if ($this->systemFilterObject->isIncluded($this->systemFilterObject->MODERN)) {
            $base['Handgun'] = 'Handgun';
            $base['Longarm'] = 'Longarm';
            $base['Heavy Weapons'] = 'Heavy Weapons';
        }
        return $base;
        
    }

    public function getListReachCategory()
    {
        return array('Melee' => 'Melee',
                     'Ranged' => 'Ranged',
                     'Explosives' => 'Explosives'
                     );
        
    }    
    
    public function getListEncumbrancecategory()
    {
        return array('Unarmed' => 'Unarmed', 
                     'Light' => 'Light',
                     'One-handed' => 'One-handed',
                     'Two-handed' => 'Two-handed',
                     'Siege' => 'Siege weapon'
                     );
        
    }    
    
    public function getListRateOfFire()
    {
        return array('1' => 'Load every round', 
                     'Si' => 'Single Shot',
                     'S' => 'Semiautomatic',
                     'A' => 'Automatic'
                     
                     );
        
    }      
    
}

