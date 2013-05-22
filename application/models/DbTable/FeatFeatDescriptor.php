<?php

class Application_Model_DbTable_FeatFeatDescriptor extends Zend_Db_Table_Abstract
{

    protected $_name = 'feat_feattype';
    protected $_primary = 'fft_id';
    protected $_parentlink = 'fft_type';
    protected $_childlink = 'fft_feat';   
    
    protected $_referenceMap = array (
        'Feat' => array(
            'columns' => array('fft_feat'),
            'refTableClass' => 'Application_Model_DbTable_Feat',
            'refColumns' => array('fea_id')
        ),
        'Descriptor' => array(
            'columns' => array('fft_type'),
            'refTableClass' => 'Application_Model_DbTable_FeatDescriptor',
            'refColumns' => array('fty_id')
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
            $inPost[] = $subform['fty_id'];
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

