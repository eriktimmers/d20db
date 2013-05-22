<?php

class Application_Model_Source
{
    protected $table;    
    protected $prefix = 'src_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Source();
        
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();        
    }
    
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            $aSet['sct_name'] = $oSet->findParentRow('Application_Model_DbTable_SourceType')->sct_name;
            $aSet['sys_name'] = $oSet->findParentRow('Application_Model_DbTable_Gamesystem')->sys_name;
            $aSet['wrl_name'] = $oSet->findParentRow('Application_Model_DbTable_World')->wrl_name;
            return $aSet;
        }
        return false;
    }

    public function all($aFilter=null)
    {
        
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('source', 
                     array('src_id', 'src_name', 
                           'src_abbriviation', 'src_publisher')
                    );
        $query->joinLeft('sourcetype', 'src_type = sct_id',   array('sct_name'));
        $query->joinLeft('systeem',    'src_system = sys_id', array('sys_name'));
        $query->joinLeft('world',      'src_world = wrl_id',  array('wrl_name'));
        if (array_key_exists('filter', $aFilter)) {
            $query->where('src_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }
        if (array_key_exists('filter_publisher', $aFilter)) {
            $query->where('src_publisher LIKE ?', '%' . $aFilter['filter_publisher'] . '%');
        }
        if (array_key_exists('filter_type', $aFilter) && $aFilter['filter_type'] > 0) {
            $query->where('src_type = ?', $aFilter['filter_type']);
        }
        if (array_key_exists('filter_system', $aFilter) && $aFilter['filter_system'] > 0) {
            $query->where('src_system = ?', $aFilter['filter_system']);
        }
        if (array_key_exists('filter_world', $aFilter) && $aFilter['filter_world'] > 0) {
            $query->where('src_world = ?', $aFilter['filter_world']);
        }
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }             

        $query->order('src_name ASC');
        $query->limit(150);
        return $this->table->fetchAll($query)->toArray();
    }     
    
    public function save($id, $options)
    {        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("src_id = ?", $id);
            $this->table->update($options, $where);
        } else {
            $this->table->insert($options);
        }
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("src_id = ?", $id);
            $this->table->delete($where);
        }
        
    }    
    
    public function getListHavingClasses()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('class_source', 'src_id = clso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }        
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }    
    
    public function getListHavingFeats()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('feat_source', 'src_id = fts_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }             
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }    

    public function getListHavingRaces()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('race_source', 'src_id = rcso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }
    
    
        
    public function getListHavingSkills()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('skill_source', 'src_id = skso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }
        
    public function getListHavingDeities()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('deity_source', 'src_id = deso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }    

    public function getListHavingSpells()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('spell_source', 'src_id = spc_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }        
    
    public function getListHavingArmour()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('equipmentarmour_source', 'src_id = arso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }       

    public function getListHavingWeapons()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        $query->join('equipmentweapon_source', 'src_id = weso_source');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }     
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }           
    
    
    public function getList()
    {
        $query = $this->table->select()->setIntegrityCheck(false)->distinct();        
        $query->from('source', 
                     array('src_id', 'src_name')
                    );    
        // !do not filter on system. danger in editpage
        $query->order('src_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }       
    
    
}

