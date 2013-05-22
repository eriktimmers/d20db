<?php

class Application_Model_DbTable_SkillSource extends Zend_Db_Table_Abstract
{

    protected $_name = 'skill_source';
    protected $_primary = 'skso_id';
    protected $_parentlink = 'skso_source';
    protected $_childlink = 'skso_skill';    
    protected $_secundary = 'skso_page';    

    protected $_referenceMap = array (
        'Skill' => array(
            'columns' => array('skso_skill'),
            'refTableClass' => 'Application_Model_DbTable_Skill',
            'refColumns' => array('rce_id')
        ),
        'Source' => array(
            'columns' => array('skso_source'),
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

