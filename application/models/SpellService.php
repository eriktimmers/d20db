<?php
/**
 * Access To Spell Table
 *
 * @package    d20database
 * @copyright  Copyright (c) 2011 Erik Timmers
 * @link       http://www.d20database.et/
 * @since      File and Class available since Release 1.0.0
 */

class Application_Model_SpellService
{

    protected $table;    
    protected $systemFilter;
    //protected $prefix = 'spl_';
    
    /**
     * Constructor
     * 
     * @return void
     */      
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Spell();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();          
    }
    
    /**
     * Return an array of spells.
     * 
     * @param  array   $aFilter  list of filter parameters
     * @return array
     */      
    public function all($aFilter=array())
    {        
        $columnArray = array('spl_id', 'spl_name', 'spl_shortdescription'
                          );        
                
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('spell', $columnArray);
        $query->joinLeft('spell_source', 'spc_spell = spl_id');
        $query->joinLeft('source'      , 'spc_source = src_id');        
        $query->joinLeft('spell_descriptor', 'spdc_spell = spl_id');        
        $query->joinLeft('spell_class' , 'spcl_spell = spl_id');
        $query->joinLeft('class',        'spcl_class = cls_id', 
                array('cls_name' => "GROUP_CONCAT(DISTINCT CONCAT(cls_name, ' ', spcl_level) ORDER BY cls_name ASC SEPARATOR ', ')"));        
                      
        if (array_key_exists('filter', $aFilter)) {
            $query->where('spl_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_class', $aFilter) && $aFilter['filter_class'] > 0) {
            $query->where('spcl_class = ?', $aFilter['filter_class']);
        }     

        if (array_key_exists('filter_level', $aFilter) && $aFilter['filter_level'] > 0) {
            $query->where('spcl_level = ?', (int)$aFilter['filter_level']);
        }   

        if (array_key_exists('filter_level', $aFilter) && $aFilter['filter_level'] == 'zero') {
            $query->where('spcl_level = 0');
        }           

        if (array_key_exists('filter_descriptors', $aFilter) && $aFilter['filter_descriptors'] > 0) {
            $query->where('spdc_descriptor = ?', (int)$aFilter['filter_descriptors']);
        }           
        
        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('spc_source = ?', $aFilter['filter_source']);
        }     

        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('spl_id');
        $query->order('spl_name ASC');
        $query->limit(150);
        return $this->table->fetchAll($query)->toArray();
    }  
    
    /**
     * Get a specific record with dependent records from child tables.
     * 
     * @param  integer  $id  id of the record
     * @return array
     */      
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            // get gamesystem
            $aSet['sys_name'] = $oSet->findParentRow('Application_Model_DbTable_Gamesystem')->sys_name;
            // get game world
            $aSet['wrl_name'] = $oSet->findParentRow('Application_Model_DbTable_World')->wrl_name;
            
            // sources
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('spell_source', array('spc_page'));
            $query->join('source', 'src_id = spc_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('spc_spell = ?', (int)$aSet['spl_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['spl_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['spl_sources'] as $value) {
                $aSet['sourceform' . $i]['src_id'] = $value['src_id'];
                $aSet['sourceform' . $i]['spc_page'] = $value['spc_page'];
                $i++;
            }
            
            // use jQuery to dynamical set the field id's
            $aSet['numberofsourceforms'] = (count($aSet['spl_sources']) > 1 ? count($aSet['spl_sources']) : 1);            
            
            // Class-level table results
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('spell_class', array('spcl_level'));
            $query->join('class', 'cls_id = spcl_class',  array('cls_id', 'cls_name'));
            $query->where('spcl_spell = ?', (int)$aSet['spl_id']);
            $query->order('cls_name ASC');
            $query->limit(50);
            $aSet['spl_classes'] = $this->table->fetchAll($query)->toArray();             
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['spl_classes'] as $value) {
                $aSet['classform' . $i]['cls_id'] = $value['cls_id'];
                $aSet['classform' . $i]['spcl_level'] = $value['spcl_level'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofclassforms'] = (count($aSet['spl_classes']) > 1 ? count($aSet['spl_classes']) : 1);               

            // Domain-level
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('spell_domain', array('spdm_level'));
            $query->join('domain', 'dom_id = spdm_domain',  array('dom_id', 'dom_name'));
            $query->where('spdm_spell = ?', (int)$aSet['spl_id']);
            $query->order('dom_name ASC');
            $query->limit(50);
            $aSet['spl_domains'] = $this->table->fetchAll($query)->toArray();             
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['spl_domains'] as $value) {
                $aSet['domainform' . $i]['dom_id'] = $value['dom_id'];
                $aSet['domainform' . $i]['spdm_level'] = $value['spdm_level'];
                $i++;
            }
            
            
            // use jQuery to dynamically set the field id's
            $aSet['numberofdomainforms'] = (count($aSet['spl_domains']) > 1 ? count($aSet['spl_domains']) : 1);               
            
            // Descriptors
            $descriptors = $oSet->findManyToManyRowset('Application_Model_DbTable_SpellDescriptor', 
                                                       'Application_Model_DbTable_SpellSpellDescriptor');

            if (is_object($descriptors)) {
                 $aSet['spl_descriptors'] = $descriptors->toArray();
            }
            
            $i = 1;
            foreach($aSet['spl_descriptors'] as $value) {
                $aSet['descriptorform' . $i]['dcp_id'] = $value['dcp_id'];
                $i++;
            }        
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofdescriptorforms'] = (count($aSet['spl_descriptors']) > 1 ? count($aSet['spl_descriptors']) : 1);             
            
            // Schools
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('spell_school');
            $query->join('subschool', 'subs_id = spsc_subschool',  array('subs_id', 'subs_name'));
            $query->join('school', 'sch_id = subs_school',  array('sch_name'));
            $query->where('spsc_spell = ?', (int)$aSet['spl_id']);
            $query->order(array('sch_name ASC', 'subs_name ASC'));
            $query->limit(50);
            $aSet['spl_schools'] = $this->table->fetchAll($query)->toArray();             
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['spl_schools'] as $value) {
                $aSet['schoolform' . $i]['subs_id'] = $value['subs_id'];
                $i++;
            }
                        
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofschoolforms'] = (count($aSet['spl_schools']) > 1 ? count($aSet['spl_schools']) : 1);                   
            
            
            return $aSet;
        }
        return false;
    }
   
    
    /**
     * save record with dependent records from child tables.
     * 
     * @param  integer   $id  id of the record
     * @param  Zend_Form $form 
     * @return array
     */     
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        // if the form has an id update the record else insert
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("spl_id = ?", $id);
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
            if (substr($key, 0, 9) == 'classform') {
                if ($value['cls_id']) {
                    $aClassforms[] = $value;
                }
            }
            if (substr($key, 0, 10) == 'domainform') {
                if ($value['dom_id']) {
                    $aDomainforms[] = $value;
                }
            }
            if (substr($key, 0, 10) == 'schoolform') {
                if ($value['subs_id']) {
                    $aSchoolforms[] = $value;
                }
            }             
            if (substr($key, 0, 14) == 'descriptorform') {
                if ($value['dcp_id']) {
                    $aDescriptorforms[] = $value;
                }
            }              
        }        
        
        $spellSource = new Application_Model_DbTable_SpellSource();
        $spellSource->save($id, $aSourceforms);
        $spellClass = new Application_Model_DbTable_SpellClass();
        $spellClass->save($id, $aClassforms);         
        $spellDomain = new Application_Model_DbTable_SpellDomain();
        $spellDomain->save($id, $aDomainforms);          
        $spellSchool = new Application_Model_DbTable_SpellSchool();
        $spellSchool->save($id, $aSchoolforms); 
        $spellDescriptor = new Application_Model_DbTable_SpellSpellDescriptor();
        $spellDescriptor->save($id, $aDescriptorforms);         
        return $id;
        
    }    
    
    /**
     * delete record
     * 
     * @param  integer   $id  id of the record
     * @return void
     */    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("spl_id = ?", $id);
            $this->table->delete($where);
        }
        
    }        
    
    /**
     * make a new record based on the old one
     * 
     * @param  integer   $id  id of the record
     * @return void
     */     
    public function copy($id)
    {
        if ($id) {
            
            $db = $this->table->getAdapter();
            $sSql = Application_Model_Util::SqlForCopy('spell', 'spl_id', 
                array(
                    'null', "CONCAT(spl_name, ' (2)')", 'spl_systeem', 'spl_castingtime', 'spl_range', 
                    'spl_effecttype', 'spl_effect', 'spl_duration', 'spl_savingthrow', 
                    'spl_spellresistance', 'spl_components', 'spl_material', 'spl_world', 
                    'spl_shortdescription', 'spl_mediumdescription',
                    'spl_longdescription', 'spl_img'
                    )
                );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
            $newId = $db->lastInsertId();
            
            $sSql = Application_Model_Util::SqlForCopy('spell_school', 'spsc_spell',
                array(
                    'null', "'" . $newId . "'", "spsc_subschool" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);
            
            $sSql = Application_Model_Util::SqlForCopy('spell_source', 'spc_spell',
                array(
                    'null', "'" . $newId . "'", "spc_source", "spc_page" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);        
            
            $sSql = Application_Model_Util::SqlForCopy('spell_class', 'spcl_spell',
                array(
                    'null', "'" . $newId . "'", "spcl_class", "spcl_level" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);              
            
            $sSql = Application_Model_Util::SqlForCopy('spell_domain', 'spdm_spell',
                array(
                    'null', "'" . $newId . "'", "spdm_domain", "spdm_level" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);            
            
            $sSql = Application_Model_Util::SqlForCopy('spell_descriptor', 'spdc_spell',
                array(
                    'null', "'" . $newId . "'", "spdc_descriptor" 
                )
            );
            $sSql = $db->quoteInto($sSql, $id);
            $db->query($sSql);              
            
        }        
        
        
    }     
    
    
}

