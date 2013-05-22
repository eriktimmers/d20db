<?php

class Application_Model_RaceService
{

    protected $table;    
    protected $prefix = 'rce_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Race();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();          
    }

    public function all($aFilter=null)
    {
        
        $columnArray = array('rce_id', 'rce_ecl',
                           'rce_att' => "CONCAT( " .
                           "IF(`rcs_attr_str` < 0, CONCAT('Str: ', `rcs_attr_str`, '; '), ''), " .
                           "IF(`rcs_attr_str` > 0, CONCAT('Str: +', `rcs_attr_str`, '; '), ''), " .
                           "IF(`rcs_attr_con` < 0, CONCAT('Con: ', `rcs_attr_con`, '; '), ''), " .
                           "IF(`rcs_attr_con` > 0, CONCAT('Con: +', `rcs_attr_con`, '; '), ''), " .
                           "IF(`rcs_attr_dex` < 0, CONCAT('Dex: ', `rcs_attr_dex`, '; '), ''), " .
                           "IF(`rcs_attr_dex` > 0, CONCAT('Dex: +', `rcs_attr_dex`, '; '), ''), " .
                           "IF(`rcs_attr_int` < 0, CONCAT('Int: ', `rcs_attr_int`, '; '), ''), " .
                           "IF(`rcs_attr_int` > 0, CONCAT('Int: +', `rcs_attr_int`, '; '), ''), " .
                           "IF(`rcs_attr_wis` < 0, CONCAT('Wis: ', `rcs_attr_wis`, '; '), ''), " .
                           "IF(`rcs_attr_wis` > 0, CONCAT('Wis: +', `rcs_attr_wis`, '; '), ''), " .
                           "IF(`rcs_attr_cha` < 0, CONCAT('Cha: ', `rcs_attr_cha`, '; '), ''), " .
                           "IF(`rcs_attr_cha` > 0, CONCAT('Cha: +', `rcs_attr_cha`, '; '), '') " .
                           ")  "
                          );
        if (array_key_exists('dosubraces', $aFilter) && $aFilter['dosubraces'] == 1) {
            $columnArray['rce_name'] = "IF(`rce_subrace` IS NULL OR `rce_subrace` = '', `rce_name`, CONCAT(`rce_name`, ', ', `rce_subrace`))";
        } else {
            $columnArray[] = 'rce_name';            
        }
        
                
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('race', $columnArray);
        $query->joinLeft('race_source', 'rcso_race = rce_id');
        $query->joinLeft('source',      'rcso_source = src_id', array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));
              
        
        if (array_key_exists('filter', $aFilter)) {
            $query->where('rce_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('rcso_source = ?', $aFilter['filter_source']);
        }     
        
        if (!array_key_exists('dosubraces', $aFilter) || $aFilter['dosubraces'] == 0) {
            $query->where('rce_ismainrace = ?', 'Y');
        }             

        if (array_key_exists('onlyecl0', $aFilter) && $aFilter['onlyecl0'] == 1) {
            $query->where('rce_ecl = 0');
        }           
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('rce_id');
        $query->order('rce_name ASC');
        $query->limit(150);
        return $this->table->fetchAll($query)->toArray();
    }    
    
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            $aSet['wrl_name'] = $oSet->findParentRow('Application_Model_DbTable_World')->wrl_name;
            $aSet['vis_name'] = $oSet->findParentRow('Application_Model_DbTable_Vision')->vis_name;
            $aSet['rce_favouredclassClass'] = $oSet->findParentRow('Application_Model_DbTable_Class');
            
            // subraces
            if ($aSet['rce_ismainrace'] == 'Y') {
                $columnArray = array('rce_id', 'rce_ecl',
                               'rce_name' => "IF(`rce_subrace` IS NULL OR `rce_subrace` = '', `rce_name`, CONCAT(`rce_name`, ', ', `rce_subrace`))",
                               'rce_att' => "CONCAT( " .
                               "IF(`rcs_attr_str` < 0, CONCAT('Str: ', `rcs_attr_str`, '; '), ''), " .
                               "IF(`rcs_attr_str` > 0, CONCAT('Str: +', `rcs_attr_str`, '; '), ''), " .
                               "IF(`rcs_attr_con` < 0, CONCAT('Con: ', `rcs_attr_con`, '; '), ''), " .
                               "IF(`rcs_attr_con` > 0, CONCAT('Con: +', `rcs_attr_con`, '; '), ''), " .
                               "IF(`rcs_attr_dex` < 0, CONCAT('Dex: ', `rcs_attr_dex`, '; '), ''), " .
                               "IF(`rcs_attr_dex` > 0, CONCAT('Dex: +', `rcs_attr_dex`, '; '), ''), " .
                               "IF(`rcs_attr_int` < 0, CONCAT('Int: ', `rcs_attr_int`, '; '), ''), " .
                               "IF(`rcs_attr_int` > 0, CONCAT('Int: +', `rcs_attr_int`, '; '), ''), " .
                               "IF(`rcs_attr_wis` < 0, CONCAT('Wis: ', `rcs_attr_wis`, '; '), ''), " .
                               "IF(`rcs_attr_wis` > 0, CONCAT('Wis: +', `rcs_attr_wis`, '; '), ''), " .
                               "IF(`rcs_attr_cha` < 0, CONCAT('Cha: ', `rcs_attr_cha`, '; '), ''), " .
                               "IF(`rcs_attr_cha` > 0, CONCAT('Cha: +', `rcs_attr_cha`, '; '), '') " .
                               ")  "
                              );

                $subraceSelect = $this->table->select()->setIntegrityCheck(false)
                                 ->from('race', $columnArray)
                                 ->joinLeft('race_source', 'rcso_race = rce_id')
                                 ->joinLeft('source',      'rcso_source = src_id', 
                                         array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"))
                                 ->where('rce_name LIKE ?', $aSet['rce_name'])
                                 ->where("rce_ismainrace = 'N'")
                                 ->group('rce_id')
                                 ->order('rce_name ASC')
                                 ->limit(150);       
                if ($this->systemFilter) {
                    $subraceSelect->where("src_system IN " . $this->systemFilter);
                }                     

                $aSet['rce_subracelist'] = $this->table->fetchAll($subraceSelect)->toArray();
            } else {
                $aSet['rce_subracelist'] = array();
            }

                               
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('race_source', array('rcso_page'));
            $query->join('source', 'src_id = rcso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('rcso_race = ?', (int)$aSet['rce_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['rce_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['rce_sources'] as $value) {
                $aSet['subform' . $i]['src_id'] = $value['src_id'];
                $aSet['subform' . $i]['rcso_page'] = $value['rcso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsubforms'] = (count($aSet['rce_sources']) > 1 ? count($aSet['rce_sources']) : 1);
                       
            return $aSet;
        }
        return false;
    }     

    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("rce_id = ?", $id);
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
        
        $raceSource = new Application_Model_DbTable_RaceSource();
        $raceSource->save($id, $aSubforms);
        return $id;
        
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("rce_id = ?", $id);
            $this->table->delete($where);
        }
        
    }        
    
    public function copy($id)
    {
        if ($id) {
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('race', 'rce_id', 
                array(
                    'null', 'rce_name', 'rce_subrace', 'rce_group', 'rce_ismainrace', 
                    'rce_ecl', 'rce_size', 'rce_speed', 'rce_vision', 'rcs_attr_str', 
                    'rcs_attr_con', 'rcs_attr_dex', 'rcs_attr_int', 'rcs_attr_wis', 
                    'rcs_attr_cha', 'rce_naturalarmor', 'rce_basehd', 
                    'rce_favouredclass', 'null', 'null', 'rce_world', 'null')               
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
        }
        
    }    
}

