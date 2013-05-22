<?php

class Application_Model_DeityService
{

    protected $table;    
    protected $prefix = 'dei_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Deity();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();          
    }
    
    public function all($aFilter=null)
    {
        
        $columnArray = array('dei_id', 'dei_name', 'dei_domains', 'dei_weapon'
                          );        
                
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('deity', $columnArray);
        $query->joinLeft('deity_source',   'deso_deity = dei_id');
        $query->joinLeft('deity_pantheon', 'dei_pantheon = panth_id', array('panth_name'));
        $query->joinLeft('alignment',      'dei_alignment = al_id', array('al_name'));
        $query->joinLeft('source',         'deso_source = src_id', 
                array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));        
                      
        if (array_key_exists('filter', $aFilter)) {
            $query->where('dei_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('deso_source = ?', $aFilter['filter_source']);
        }     

        if (array_key_exists('filter_pantheon', $aFilter) && $aFilter['filter_pantheon'] > 0) {
            $query->where('dei_pantheon = ?', $aFilter['filter_pantheon']);
        }             

        if (array_key_exists('filter_domain', $aFilter)) {
            $query->where('dei_domains LIKE ?', '%' . $aFilter['filter_domain'] . '%');
        }             

        
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('dei_id');
        $query->order('dei_name ASC');
        $query->limit(150);
        return $this->table->fetchAll($query)->toArray();
    }    
    
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            $aSet['al_name'] = $oSet->findParentRow('Application_Model_DbTable_Alignment')->al_name;
            $aSet['panth_name'] = $oSet->findParentRow('Application_Model_DbTable_Pantheon')->panth_name;
            $aSet['dra_name'] = $oSet->findParentRow('Application_Model_DbTable_DeityRank')->dra_name;
            
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('deity_source', array('deso_page'));
            $query->join('source', 'src_id = deso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('deso_deity = ?', (int)$aSet['dei_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['dei_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['dei_sources'] as $value) {
                $aSet['subform' . $i]['src_id'] = $value['src_id'];
                $aSet['subform' . $i]['deso_page'] = $value['deso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsubforms'] = (count($aSet['dei_sources']) > 1 ? count($aSet['dei_sources']) : 1);
                       
            return $aSet;
        }
        return false;
    }     

    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("dei_id = ?", $id);
            $this->table->update($options, $where);
            
        } else {
            $this->table->insert($options);
            $id = $this->table->getAdapter()->lastInsertId();
        }
        
        $options = $form->getValues();
        
        foreach((array)$options as $key=>$value) {
            if (substr($key, 0, 7) == 'subform') {
                if ($value['src_id']) {
                    $aSubforms[] = $value;
                }
            }            
        }
        
        $raceSource = new Application_Model_DbTable_DeitySource();
        $raceSource->save($id, $aSubforms);
        return $id;
        
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("dei_id = ?", $id);
            $this->table->delete($where);
        }
        
    }        
    
    public function copy($id)
    {
        if ($id) {
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('deity', 'dei_id', 
                array(
                    'null', 'dei_name', 'dei_subrace', 'dei_group', 'dei_ismainrace', 
                    'dei_ecl', 'dei_size', 'dei_speed', 'dei_vision', 'rcs_attr_str', 
                    'rcs_attr_con', 'rcs_attr_dex', 'rcs_attr_int', 'rcs_attr_wis', 
                    'rcs_attr_cha', 'dei_naturalarmor', 'dei_basehd', 
                    'dei_favouredclass', 'null', 'null', 'dei_world', 'null')               
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
        }
        
    }     
    
    
    
}

