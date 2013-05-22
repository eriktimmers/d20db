<?php

class Application_Model_DbTable_RaceSource extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'race_source';
    protected $_primary = 'rcso_id';
    protected $_sequence = true;    
    
    protected $_parentlink = 'rcso_source';
    protected $_childlink = 'rcso_race';
    protected $_secundary = 'rcso_page';
    protected $_linkedId = 'src_id';

    protected $_referenceMap = array (
        'Race' => array(
            'columns' => array('rcso_race'),
            'refTableClass' => 'Application_Model_DbTable_Race',
            'refColumns' => array('rce_id')
        ),
        'Source' => array(
            'columns' => array('rcso_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
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

