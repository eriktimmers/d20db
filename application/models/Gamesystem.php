<?php

class Application_Model_Gamesystem
{

    protected $table;   
    protected $prefix = 'sys';    
    
    public function __construct() {         
        $this->table = new Application_Model_DbTable_Gamesystem();
        $session = new Zend_Session_Namespace('SystemFilter');
        $this->systemFilter = $session->filter->get();         
    }

    public function find($id)
    {
        return $this->table->find($id)->current()->toArray();
    }
    
    public function all($filter=null)
    {
        $query = $this->table->select();
        $query->order('sys_name ASC');
        if ($this->systemFilter) {
            $query->where("sys_id IN " . $this->systemFilter);
        }           
        return $this->table->fetchAll($query)->toArray();
    }    
    
    public function save($id, $options)
    {        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("sys_id = ?", $id);
            $this->table->update($options, $where);
        } else {
            $this->table->insert($options);
        }
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto("sys_id = ?", $id);
            $this->table->delete($where);
        }
        
    }
    
    public function getList()
    {
        $aList = $this->all();
        foreach((array)$aList as $aRecord) {
            $aReturn[$aRecord[$this->getPrefix() . 'id']] = $aRecord[$this->getPrefix() . 'name'];
        }
        return $aReturn;
        
    }     
    
    public function getPrefix()
    {
        return $this->prefix . '_';
    }    
    
}

