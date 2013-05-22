<?php

class Application_Model_DbTable_FeatSource extends Zend_Db_Table_Abstract
{

    protected $_name = 'feat_source';
    protected $_primary = 'fts_id';
    protected $_parentlink = 'fts_source';
    protected $_childlink = 'fts_feat';
    protected $_secundary = 'fts_page';
    
    
    protected $_referenceMap = array (
        'Class' => array(
            'columns' => array('fts_feat'),
            'refTableClass' => 'Application_Model_DbTable_Feat',
            'refColumns' => array('cls_id')
        ),
        'Source' => array(
            'columns' => array('fts_source'),
            'refTableClass' => 'Application_Model_DbTable_source',
            'refColumns' => array('fea_id')
        )
    );     
    
    public function save($nId, $values) 
    {        
        
        $query = $this->select()->setIntegrityCheck(false);
        $query->from($this->_name, array($this->_parentlink));
        $query->where($this->_childlink . ' = ?', (int)$nId);
        $result = $this->fetchAll($query)->toArray();
        
        foreach((array)$result as $row) {
            $inDatabase[] = $row[$this->_parentlink];
        }

        foreach((array)$values as $subform) {
            $inPost[] = $subform['src_id'];
            $toEdit[$subform['src_id']] = $subform[$this->_secundary];
        }        
        
        //var_dump($inDatabase);
        //var_dump($inPost);
        
        $aToDelete = array_diff((array)$inDatabase, (array)$inPost);
        $aToInsert = array_diff((array)$inPost, (array)$inDatabase);
        $aToEdit   = array_intersect((array)$inPost, (array)$inDatabase);
        
        foreach((array)$aToDelete as $src) {        
            $sSql  = $this->getAdapter()->quoteInto($this->_childlink . ' = ?', $nId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto($this->_parentlink . ' = ?', $src);
            $this->delete($sSql);
        }

        foreach((array)$aToInsert as $src) {
            $this->insert(array($this->_childlink => $nId,
                                $this->_parentlink => $src,
                                $this->_secundary => $toEdit[$src]
                               ));          
        }
        
        foreach((array)$aToEdit as $src) {
            $sSql  = $this->getAdapter()->quoteInto($this->_childlink . ' = ?', $nId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto($this->_parentlink . ' = ?', $src);
            $this->update(array($this->_secundary => $toEdit[$src]), $sSql);            
      
        }        
        
    }    


}

