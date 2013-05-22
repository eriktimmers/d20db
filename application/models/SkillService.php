<?php

class Application_Model_SkillService
{

    protected $table;    
    protected $prefix = 'skil_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Skill();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();          
    }
    
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            $aSet['wrl_name'] = $oSet->findParentRow('Application_Model_DbTable_World')->wrl_name;
            
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('skill_source', array('skso_page'));
            $query->join('source', 'src_id = skso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('skso_skill = ?', (int)$aSet['skil_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['skil_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['skil_sources'] as $value) {
                $aSet['subform' . $i]['src_id'] = $value['src_id'];
                $aSet['subform' . $i]['skso_page'] = $value['skso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsubforms'] = (count($aSet['skil_sources']) > 1 ? count($aSet['skil_sources']) : 1);
                       
            return $aSet;
        }
        return false;
    }    
    
    public function all($aFilter=null)
    {
        
        $columnArray = array('skil_id', 'skil_name', 'skil_keyability');

        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('skill', $columnArray);
        $query->joinLeft('skill_source', 'skso_skill = skil_id');
        $query->joinLeft('source',       'skso_source = src_id', 
                array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));
              
        
        if (array_key_exists('filter', $aFilter)) {
            $query->where('skil_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('skso_source = ?', $aFilter['filter_source']);
        }     
        
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('skil_id');
        $query->order('skil_name ASC');
        $query->limit(150);
                
        return $this->table->fetchAll($query)->toArray();    
    }
    
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("skil_id = ?", $id);
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
        
        $raceSource = new Application_Model_DbTable_SkillSource();
        $raceSource->save($id, $aSubforms);
        return $id;
        
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("skil_id = ?", $id);
            $this->table->delete($where);
        }
        
    }        
    
    public function copy($id)
    {
        if ($id) {
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('skill', 'skil_id', 
                array(
                    'null', 'skil_name', 'skil_keyability', 'skil_trainedonly', 
                    'skil_armor', 'skil_description', 
                    'skil_check', 'skil_action', 'skil_tryagain', 'skil_special',
                    'skil_synergy', 'skil_restriction', 'skil_untrained', 
                    'skil_epic', 'skil_world')               
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
        }
        
    }       
}

