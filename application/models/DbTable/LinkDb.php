<?php

class Application_Model_DbTable_LinkDb extends Zend_Db_Table_Abstract
{

    public function save($nId, $values) 
    {        
        if ($this->_secundary) {
            $this->saveExtraFieldMultiMulti($nId, $values);
        } else {
            $this->saveCleanMultiMulti($nId, $values);
        }
        
    }    
    
    
    protected function saveExtraFieldMultiMulti($nId, $values) 
    {        
        
        // select links available in db
        $query = $this->select()->setIntegrityCheck(false);
        $query->from($this->_name, array($this->_parentlink));
        $query->where($this->_childlink . ' = ?', (int)$nId);
        $result = $this->fetchAll($query)->toArray();
        
        // make an id-array
        foreach((array)$result as $row) {
            $inDatabase[] = $row[$this->_parentlink];
        }

        // make an id-array of the formsubmitted values and 
        // make a lookup table for the linked(secundary) data
        foreach((array)$values as $subform) {
            $inPost[] = $subform[$this->_linkedId];
            $toEdit[$subform[$this->_linkedId]] = $subform[$this->_secundary];
        }        
        
        //var_dump($inDatabase);
        //var_dump($inPost);
        
        // decide what to do
        $aToDelete = array_diff((array)$inDatabase, (array)$inPost);
        $aToInsert = array_diff((array)$inPost, (array)$inDatabase);
        $aToEdit   = array_intersect((array)$inPost, (array)$inDatabase);
        
        // do the deletes
        foreach((array)$aToDelete as $src) {        
            $sSql  = $this->getAdapter()->quoteInto($this->_childlink . ' = ?', $nId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto($this->_parentlink . ' = ?', $src);
            $this->delete($sSql);
        }

        // do the inserts
        foreach((array)$aToInsert as $src) {
            $this->insert(array($this->_childlink => $nId,
                                $this->_parentlink => $src,
                                $this->_secundary => $toEdit[$src]
                               ));          
        }
        
        // do the edits
        foreach((array)$aToEdit as $src) {
            $sSql  = $this->getAdapter()->quoteInto($this->_childlink . ' = ?', $nId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto($this->_parentlink . ' = ?', $src);
            $this->update(array($this->_secundary => $toEdit[$src]), $sSql);            
      
        }        
        
    } 
    
    protected function saveCleanMultiMulti($nId, $values) 
    {        
        
        $query = $this->select()->setIntegrityCheck(false);
        $query->from($this->_name, array($this->_parentlink));
        $query->where($this->_childlink . ' = ?', (int)$nId);
        $result = $this->fetchAll($query)->toArray();
        
        foreach((array)$result as $row) {
            $inDatabase[] = $row[$this->_parentlink];
        }

        foreach((array)$values as $subform) {
            $inPost[] = $subform[$this->_linkedId];
        }        
        
        //var_dump($inPost);
        
        $aToDelete = array_diff((array)$inDatabase, (array)$inPost);
        $aToInsert = array_diff((array)$inPost, (array)$inDatabase);

        //var_dump($aToDelete);        
        //var_dump($aToInsert);
        
        foreach((array)$aToDelete as $src) {        
            $sSql  = $this->getAdapter()->quoteInto($this->_childlink . ' = ?', $nId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto($this->_parentlink . ' = ?', $src);
            $this->delete($sSql);
        }

        foreach((array)$aToInsert as $src) {
            $this->insert(array($this->_childlink => $nId,
                                $this->_parentlink => $src
                               ));          
        }
           
        
    }     
    

}