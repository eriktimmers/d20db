<?php

class Application_Model_SchoolService
{

    protected $schoolTable;    
    protected $subschoolTable;
    
    public function __construct() 
    {         
        $this->schoolTable = new Application_Model_DbTable_School();
        $this->subschoolTable = new Application_Model_DbTable_Subschool();
    }
    
    public function findSchool($id)
    {    
        $oSet = $this->schoolTable->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            return $aSet;
        }
        
    }

    public function findSubschool($id)
    {    
        $oSet = $this->subschoolTable->find($id)->current();
        if (is_object($oSet)) {
            $aSet = $oSet->toArray();
            return $aSet;
        }        
    }
    
    public function all()
    {
        $query = $this->subschoolTable
                      ->select()
                      ->setIntegrityCheck(false);
        
        $query->from('subschool', array('subs_id', 'subs_name'));
        $query->join('school', 'subs_school = sch_id', 
                        array('sch_id', 'sch_name', 'sch_abbreviation'));
        $query->order(array('sch_name ASC', 'subs_name ASC'));
        return $this->subschoolTable->fetchAll($query)->toArray();        
        
    }    

    public function getListSchools()
    {
        $query = $this->schoolTable->select()->setIntegrityCheck(false)->distinct();        
        $query->from($this->schoolTable, 
                     array('sch_id', 'sch_name')
                    );    
        // !do not filter on system. danger in editpage
        $query->order('sch_name ASC');
        
        return $this->schoolTable->getAdapter()->fetchPairs($query);        
    }
    
    public function getList()
    {
        $query = $this->subschoolTable->select()->setIntegrityCheck(false);        
        $query->from($this->subschoolTable, 
                     array('subs_id', 'subs_name')
                    );    
        $query->join('school', 'subs_school = sch_id', array('sch_name'));        
        // !do not filter on system. danger in editpage
        $query->order(array('sch_name ASC', 'subs_name ASC'));
                
        $aList = $this->subschoolTable->fetchAll($query)->toArray();    
       
        
        foreach((array)$aList as $value) {
            $aReturn[$value['subs_id']] = $value['sch_name'] .
                ( $value['subs_name'] ? ' (' . $value['subs_name'] . ')' : '');
        }   
        
        return $aReturn;
    }    
    
    public function saveSchool($id, $options)
    {   
        if ($id) {
            $where = $this->schoolTable->getAdapter()->quoteInto("sch_id = ?", $id);
            $this->schoolTable->update($options, $where);
        } else {
            $this->schoolTable->insert($options);
            $aSubschool = array(
                                'subs_school' => $this->schoolTable->getAdapter()->lastInsertId()
                               );
            $this->subschoolTable->insert($aSubschool);
        }
    }

    public function saveSubschool($id, $options)
    {        
        if ($id) {
            $where = $this->subschoolTable->getAdapter()->quoteInto("subs_id = ?", $id);
            $this->subschoolTable->update($options, $where);
        } else {
            $this->subschoolTable->insert($options);
        }
    }    
    
    public function schoolDelete($id)
    {
        if ($id) {
            $where = $this->schoolTable->getAdapter()->quoteInto("sch_id = ?", $id);
            $this->schoolTable->delete($where);
        }
        
    }           
    
    public function subschoolDelete($id)
    {
        if ($id) {
            $where = $this->subschoolTable->getAdapter()->quoteInto("subs_id = ?", $id);
            $this->subschoolTable->delete($where);
        }
        
    }      
}

