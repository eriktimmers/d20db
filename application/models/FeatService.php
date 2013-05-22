<?php

class Application_Model_FeatService
{

    protected $table;    
    protected $prefix = 'fea_';
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Feat();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();        
    }
    
    public function all($aFilter=null)
    {
        
        $query = $this->table->select()->setIntegrityCheck(false);
        $query->from('feats', 
                     array('fea_id', 'fea_name', 'fea_shortdescription'
                          )
                    );
        $query->joinLeft('feat_source', 'fts_feat = fea_id');
        $query->joinLeft('source',      'fts_source = src_id', array('src_name' => "GROUP_CONCAT(DISTINCT src_name ORDER BY src_name ASC SEPARATOR ', ')"));
        
        $query->joinLeft('feat_feattype', 'fft_feat = fea_id');      
        
        if (array_key_exists('filter', $aFilter)) {
            $query->where('fea_name LIKE ?', '%' . $aFilter['filter'] . '%');
        }

        if (array_key_exists('filter_source', $aFilter) && $aFilter['filter_source'] > 0) {
            $query->where('fts_source = ?', $aFilter['filter_source']);
        }     

        if (array_key_exists('filter_descriptor', $aFilter) && $aFilter['filter_descriptor'] > 0) {
            $query->where('fft_type = ?', $aFilter['filter_descriptor']);
        }
        if ($this->systemFilter) {
            $query->where("src_system IN " . $this->systemFilter . " OR src_system IS NULL ");
        }        
        
        $query->group('fea_id');
        $query->order('fea_name ASC');
        $query->limit(100);
        return $this->table->fetchAll($query)->toArray();
    }    

    public function find($id)
    {
        $oSet = $this->table->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            
            $query = $this->table->select()->setIntegrityCheck(false);
            $query->from('feat_source', array('fts_page'));
            $query->join('source', 'src_id = fts_source',  array('src_id', 'src_name', 'src_abbriviation'));
            $query->where('fts_feat = ?', (int)$aSet['fea_id']);
            $query->order('src_name ASC');
            $query->limit(50);
            $aSet['fea_sources'] = $this->table->fetchAll($query)->toArray(); 
            
            // make sources into zend_form friendly array
            $i = 1;
            foreach($aSet['fea_sources'] as $value) {
                $aSet['subform' . $i]['src_id'] = $value['src_id'];
                $aSet['subform' . $i]['fts_page'] = $value['fts_page'];
                $i++;
            }
            
            // use jQuery to dynamicaklly set the field id's
            $aSet['numberofsubforms'] = (count($aSet['fea_sources']) > 1 ? count($aSet['fea_sources']) : 1);
            
            $descriptors = $oSet->findManyToManyRowset('Application_Model_DbTable_FeatDescriptor', 
                                                    'Application_Model_DbTable_FeatFeatDescriptor');
            

            if (is_object($descriptors)) {
                 $aSet['fea_descriptor'] = $descriptors->toArray();
            }
           
            
            $i = 1;
            foreach($aSet['fea_descriptor'] as $value) {
                $aSet['typeform' . $i]['fty_id'] = $value['fty_id'];
                $i++;
            }            
            
            return $aSet;
        }
        return false;
    }       
    
    public function save($id, $form)
    {        
               
        $options = $form->getValue('mainform');
        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("fea_id = ?", $id);
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
            if (substr($key, 0, 8) == 'typeform') {
                if ($value['fty_id']) {
                    $aTypeforms[] = $value;
                }
            }                  
        }
        
        var_dump($aTypeforms);
        
        $classSource = new Application_Model_DbTable_FeatSource();
        $classSource->save($id, $aSubforms);

        $classDescriptor = new Application_Model_DbTable_FeatFeatDescriptor();
        $classDescriptor->save($id, $aTypeforms);        
        
        return $id;
        
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("fea_id = ?", $id);
            $this->table->delete($where);
        }
        
    }      
    
}

