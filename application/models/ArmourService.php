<?php

class Application_Model_ArmourService
{

    protected $table;    
    protected $prefix = 'arm_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Armour();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();          
    }
    
    public function all($aFilter=null)
    {
        
        $columnArray = array('arm_id', 'arm_name', 'arm_type', 'arm_bonus', 'arm_weight'
                          );        
                
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('equipmentarmour', $columnArray);
        $query->joinLeft('equipmentarmour_source',   'arso_armour = arm_id');
        $query->joinLeft('source',                   'arso_source = src_id');        
                      
        if (array_key_exists('filter', $aFilter)) {
            $query->where('arm_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_type', $aFilter)) {
            $query->where('arm_type LIKE ?', '%' . $aFilter['filter_type'] . '%');
        }        
        
        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('arso_source = ?', $aFilter['filter_source']);
        }     
        
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('arm_id');
        $query->order(array('arm_type ASC', 'arm_name ASC'));
        $query->limit(150);

        return $this->table->fetchAll($query)->toArray();
    }     
    

    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('equipmentarmour_source', array('arso_page'));
            $query->join('source', 'src_id = arso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('arso_armour = ?', (int)$aSet['arm_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['arm_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach((array)$aSet['arm_sources'] as $value) {
                $aSet['sourceform' . $i]['src_id'] = $value['src_id'];
                $aSet['sourceform' . $i]['arso_page'] = $value['arso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsourceforms'] = (count($aSet['arm_sources']) > 1 ? count($aSet['arm_sources']) : 1);
            
            return $aSet;
        }
        return false;
    }    
    
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("arm_id = ?", $id);
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
        
        $spellSource = new Application_Model_DbTable_ArmourSource();
        $spellSource->save($id, $aSourceforms);      
        return $id;
        
    }    
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("arm_id = ?", $id);
            $this->table->delete($where);
        }
        
    }            

    public function copy($id)
    {
        if ($id) {
            
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('equipmentarmour', 'arm_id', 
                array(
                    'null', "CONCAT(arm_name, ' (2)')", 'arm_type', 
                    'arm_bonus', 'arm_maxdex', 'arm_armorcheckpenalty', 
                    'arm_arcanespellfailure', 'arm_speed30ft', 'arm_speed20ft', 
                    'arm_weight', 'arm_img', 'arm_description', 
                    'arm_progression_level', 'arm_price', 'arm_usetype'
                    )
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
            $newId = $db->lastInsertId();    

            $sSql = Application_Model_Util::SqlForCopy('equipmentarmour_source', 'arso_armour',
                array(
                    'null', "'" . $newId . "'", "arso_source", "arso_page" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
        }
        
    }
            
}

