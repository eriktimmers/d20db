<?php

class Application_Model_SimpleTable
{

    protected $table;
    protected $prefix = '';


    public function __construct($type) {
        switch(strtolower($type)) {
            case 'alignments':
                $this->table = new Application_Model_DbTable_Alignment();
                $this->prefix = 'al';
                break;
            
            case 'deityranks':
                $this->table = new Application_Model_DbTable_DeityRank();
                $this->prefix = 'dra';
                break;

            case 'domains':
                $this->table = new Application_Model_DbTable_Domain();
                $this->prefix = 'dom';
                break;
            
            case 'featdescriptors':
                $this->table = new Application_Model_DbTable_FeatDescriptor();
                $this->prefix = 'fty';
                break;
            
            case 'pantheons':
                $this->table = new Application_Model_DbTable_Pantheon();
                $this->prefix = 'panth';
                break;
            
            case 'sourcetypes':
                $this->table = new Application_Model_DbTable_SourceType();
                $this->prefix = 'sct';
                break;            
            
            case 'spelldescriptors':
                $this->table = new Application_Model_DbTable_SpellDescriptor();
                $this->prefix = 'dcp';
                break;

            case 'visions':
                $this->table = new Application_Model_DbTable_Vision();
                $this->prefix = 'vis';
                break;

            case 'damagetype':
                $this->table = new Application_Model_DbTable_WeaponDamagetype();
                $this->prefix = 'wdt';
                break;
            
            case 'worlds':
                $this->table = new Application_Model_DbTable_World();
                $this->prefix = 'wrl';
                break;
            
            case 'gamesystems':
                $this->table = new Application_Model_DbTable_Gamesystem();
                $this->prefix = 'sys'; 
                break;

            default:
                throw new Exception("Unknown simpleTable");
            
        }
    }
    
    public function getPrefix()
    {
        return $this->prefix . '_';
    }
    
    public function find($id)
    {
        return $this->table->find($id)->current()->toArray();
    }
    
    public function all($filter=null)
    {
        $query = $this->table->select();
        $query->order($this->getPrefix() . 'name ASC');
        return $this->table->fetchAll($query)->toArray();
    }
    
    public function getList()
    {
        $aList = $this->all();
        //$aReturn = array(" -- select -- ");
        foreach((array)$aList as $aRecord) {
            $aReturn[$aRecord[$this->getPrefix() . 'id']] = $aRecord[$this->getPrefix() . 'name'];
        }
        return $aReturn;
        
    }    
    
    public function save($id, $options)
    {        
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto($this->getPrefix() . "id = ?", $id);
            $this->table->update($options, $where);
        } else {
            $this->table->insert($options);
        }
    }
    
    public function delete($id)
    {
        if ($id) {
            $where = $this->table->getAdapter()->quoteInto($this->getPrefix() . "id = ?", $id);
            $this->table->delete($where);
        }
        
    }    
    
}

