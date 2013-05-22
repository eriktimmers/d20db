<?php

class Application_Model_DbTable_Deity extends Zend_Db_Table_Abstract
{

    protected $_name = 'deity';
    protected $_primary = 'dei_id';    

    protected $_referenceMap = array (
        'Pantheon' => array(
            'columns' => array('dei_pantheon'),
            'refTableClass' => 'Application_Model_DbTable_Pantheon',
            'refColumns' => array('panth_id')
        ),
        'Alignment' => array(
            'columns' => array('dei_alignment'),
            'refTableClass' => 'Application_Model_DbTable_Alignment',
            'refColumns' => array('al_id')
        ),
        'Rank' => array(
            'columns' => array('dei_rank'),
            'refTableClass' => 'Application_Model_DbTable_DeityRank',
            'refColumns' => array('dra_id')
        )        
    ); 

}

