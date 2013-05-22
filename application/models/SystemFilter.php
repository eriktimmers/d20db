<?php

class Application_Model_SystemFilter
{
    public $MODERN = array('5');
    public $DD35 = array('3');
    public $DD30 = array('4');
    public $PATHFINDER = array('4');
    public $DD3 = array('3', '4', '6');
    public $D20 = array('3', '4', '5', '6', '7');
    
    protected $formValues;
    protected $where;
    protected $valueArray;
    
    public function __construct() {
        $this->createDefault();
    }
    
    
    protected function createDefault()
    {
        $this->formValues = array("doShow_4"=>"1", "doShow_3"=>"1");
        $this->createWhere();
    }
    
    protected function createWhere()
    {
        $aTemp = array(0);
        foreach($this->formValues as $key=>$value) {
            if ($value) {                    
               $aTemp[] = (int)substr($key, 7);
            }
        }        
        $this->where = '(' . implode(', ', $aTemp) . ')';
        $this->valueArray = $aTemp;
    }
    
    
    public function getFormValues()
    {
        return $this->formValues;
    }    

    public function setFormValues($in)
    {
        $this->formValues = $in;
        $this->createWhere();
    }    
    
    public function get()
    {
        return $this->where;
    }
    
    public function isIncluded($in = array())
    {
        
        $aResult = array_intersect((array)$in, (array)$this->valueArray);
        return (count($aResult) > 0);
    }
    
    
}

