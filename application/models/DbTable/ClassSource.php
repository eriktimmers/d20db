<?php

class Application_Model_DbTable_ClassSource extends Zend_Db_Table_Abstract
{

    protected $_name = 'class_source';
    protected $_primary = 'clso_int';

    protected $_referenceMap = array (
        'Class' => array(
            'columns' => array('clso_class'),
            'refTableClass' => 'Application_Model_DbTable_Class',
            'refColumns' => array('cls_id')
        ),
        'Source' => array(
            'columns' => array('clso_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
        )
    ); 
    
    
    public function save($nClassId, $values) 
    {
        $query = $this->select()->setIntegrityCheck(false);
        $query->from('class_source', array('clso_source'));
        $query->where('clso_class = ?', (int)$nClassId);
        $result = $this->fetchAll($query)->toArray();
        
        foreach((array)$result as $row) {
            $inDatabase[] = $row['clso_source'];
        }

        foreach((array)$values as $subform) {
            $inPost[] = $subform['src_id'];
            $toEdit[$subform['src_id']] = $subform['clso_page'];
        }        
        
        //var_dump($inDatabase);
        //var_dump($inPost);
        
        $aToDelete = array_diff((array)$inDatabase, (array)$inPost);
        $aToInsert = array_diff((array)$inPost, (array)$inDatabase);
        $aToEdit   = array_intersect((array)$inPost, (array)$inDatabase);
        
        foreach((array)$aToDelete as $src) {        
            $sSql  = $this->getAdapter()->quoteInto('clso_class = ?', $nClassId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto('clso_source=?', $src);
            $this->delete($sSql);
        }

        foreach((array)$aToInsert as $src) {
            $this->insert(array('clso_class' => $nClassId,
                                'clso_source' => $src,
                                'clso_page' => $toEdit[$src]
                               ));          
        }
        
        foreach((array)$aToEdit as $src) {
            $sSql  = $this->getAdapter()->quoteInto('clso_class = ?', $nClassId);
            $sSql .= ' AND ' . $this->getAdapter()->quoteInto('clso_source=?', $src);
            $this->update(array('clso_page' => $toEdit[$src]), $sSql);            
      
        }        
        
    }

}

