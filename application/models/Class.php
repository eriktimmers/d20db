<?php

class Application_Model_Class
{

    protected $table;    
    protected $prefix = 'cls_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Class();
        
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();
    }
    
    public function all($aFilter=null)
    {
        
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('Class', 
                     array('cls_id', 'cls_name', 'cls_npc', 'cls_prestige',
                           'cls_arcanespells', 'cls_divinespells',
                           'cls_psionics'
                          )
                    );
        $query->joinLeft('world',        'cls_world = wrl_id',  array('wrl_name'));       
        $query->joinLeft('class_source', 'clso_class = cls_id');
        $query->joinLeft('source',       'clso_source = src_id', array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));
        $query->joinLeft('systeem',      'src_system = sys_id' , array('sys_name'));
        $query->where('cls_isaggregate = ?', 'N');
        if (array_key_exists('filter', $aFilter)) {
            $query->where('cls_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }
        if (!array_key_exists('doprestige', $aFilter) || $aFilter['doprestige'] == 0) {
            $query->where('cls_prestige = ?', 'N');
        }        
        if (!array_key_exists('donpc', $aFilter) || $aFilter['donpc'] == 0) {
            $query->where('cls_npc = ?', 'N');
        }    
        if (!array_key_exists('dosub', $aFilter) || $aFilter['dosub'] == 0) {
            $query->where('(ISNULL(cls_subclass) OR cls_subclass=0)');
        } 
        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('clso_source = ?', $aFilter['filter_source']);
        }         
        if ($this->systemFilter) {
           $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }
        
        
        
        /*
        if (array_key_exists('filter_world', $aFilter) && $aFilter['filter_world'] > 0) {
            $query->where('src_world = ?', $aFilter['filter_world']);
        }*/

        $query->group('cls_id');
        $query->order('cls_name ASC');
        $query->limit(100);
        return $this->table->fetchAll($query)->toArray();
    }
    
    public function allParents()
    {
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('Class', 
                     array('cls_id', 'cls_name')
                    );        
        $query->joinLeft('class_source', 'clso_class = cls_id'); 
        $query->joinLeft('source',       'clso_source = src_id');
        
        $query->where('cls_prestige = ?', 'N');
        $query->where('(ISNULL(cls_subclass) OR cls_subclass=0)');
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }        
        
        $query->order('cls_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }
    
    public function allSpellcastingClasses()
    {
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('Class', 
                     array('cls_id', 'cls_name')
                    );        
        $query->joinLeft('class_source', 'clso_class = cls_id');   
        $query->joinLeft('source',       'clso_source = src_id');
        
        $query->where('cls_prestige = ?', 'N');
        $query->where("(cls_arcanespells = 'Y' OR cls_divinespells = 'Y')");
        $query->where("(ISNULL(cls_aggregatedin) OR cls_aggregatedin = '')");
        $query->where("(ISNULL(cls_subclass) OR cls_subclass=0)");
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }        
        $query->order('cls_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }
    
    public function evenMoreSpellcastingClasses()
    {
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('Class', 
                     array('cls_id', 'cls_name')
                    );        
        $query->joinLeft('class_source', 'clso_class = cls_id');   
        $query->joinLeft('source',       'clso_source = src_id');
        
        //$query->where('cls_prestige = ?', 'N');
        $query->where("(cls_arcanespells = 'Y' OR cls_divinespells = 'Y')");
        $query->where("(ISNULL(cls_aggregatedin) OR cls_aggregatedin = '')");
        $query->where("(ISNULL(cls_subclass) OR cls_subclass=0)");
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }        
        $query->order('cls_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }    

    public function getListSpellLists()
    {
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('Class', 
                     array('cls_id', 'cls_name')
                    );        
        $query->joinLeft('class_source', 'clso_class = cls_id');   
        $query->joinLeft('source',       'clso_source = src_id');

        $query->join('spell_class', 'spcl_class = cls_id');   
        
        $query->where("(cls_arcanespells = 'Y' OR cls_divinespells = 'Y')");

        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter);
        }        
        $query->order('cls_name ASC');
        
        return $this->table->getAdapter()->fetchPairs($query);
    }    
    
    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            $aSet['wrl_name'] = $oSet->findParentRow('Application_Model_DbTable_World')->wrl_name;
            $aSet['cls_parent'] = $oSet->findParentRow('Application_Model_DbTable_Class', 'Subclass');
            $aSet['cls_aggregated'] = $oSet->findParentRow('Application_Model_DbTable_Class', 'Agregateclass');
            
                        
            $subclassSelect = $this->table->select()->setIntegrityCheck(false);
            $subclassSelect->from('Class', 
                     array('cls_id', 'cls_name', 'cls_npc', 'cls_prestige',
                           'cls_arcanespells', 'cls_divinespells',
                           'cls_psionics', 'cls_short_description'
                          )
                    );
            $subclassSelect->joinLeft('class_source', 'clso_class = cls_id');   
            $subclassSelect->joinLeft('source', 'clso_source = src_id', 
                    array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));
            $subclassSelect->where('cls_subclass = ?', $aSet['cls_id']);
            if ($this->systemFilter) {
                 $subclassSelect->where("src_system IN " . $this->systemFilter);
            }  
            $subclassSelect->group('cls_id');
            $subclassSelect->order('cls_name ASC');
            $subclassSelect->limit(150);            
            
            $aSet['cls_subclasses'] = $this->table->fetchAll($subclassSelect)->toArray();
            
            //$subclasses = $oSet->findDependentRowset('Application_Model_DbTable_Class', 'Subclass', $subclassSelect);
            
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('class_source', array('clso_page'));
            $query->join('source', 'src_id = clso_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('clso_class = ?', (int)$aSet['cls_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['cls_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['cls_sources'] as $value) {
                $aSet['subform' . $i]['src_id'] = $value['src_id'];
                $aSet['subform' . $i]['clso_page'] = $value['clso_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsubforms'] = (count($aSet['cls_sources']) > 0 ? count($aSet['cls_sources']) : 1);
            
            /* comment for documentation
            $sources = $oSet->findManyToManyRowset('Application_Model_DbTable_source', 
                                                   'Application_Model_DbTable_ClassSource');
            

            if (is_object($sources)) {
                $aSet['cls_sources'] = $sources->toArray();
            }            
            */
            
            return $aSet;
        }
        return false;
    }   
    
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("cls_id = ?", $id);
            $this->table->update($options, $where);
            
        } else {
            $this->table->insert($options);
            $id = $this->table->getAdapter()->lastInsertId();
        }
        
        $options = $form->getValues();
        
        foreach((array)$options as $key=>$value) {
            if (substr($key, 0, 7) == 'subform') {
                $aSubforms[] = $value;
            }            
        }
        
        $classSource = new Application_Model_DbTable_ClassSource();
        $classSource->save($id, $aSubforms);
        return $id;
        
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("cls_id = ?", $id);
            $this->table->delete($where);
        }
        
    }      
    
}

