<?php

class Application_Model_DbTable_DeitySource extends Application_Model_DbTable_LinkDb
{

    protected $_name = 'deity_source';
    protected $_primary = 'deso_id';
    protected $_sequence = true; 
    
    protected $_parentlink = 'deso_source';
    protected $_childlink = 'deso_deity';
    protected $_secundary = 'deso_page'; 
    protected $_linkedId = 'src_id';

    protected $_referenceMap = array (
        'Deity' => array(
            'columns' => array('deso_deity'),
            'refTableClass' => 'Application_Model_DbTable_Deity',
            'refColumns' => array('dei_id')
        ),
        'Source' => array(
            'columns' => array('deso_source'),
            'refTableClass' => 'Application_Model_DbTable_Source',
            'refColumns' => array('src_id')
        )
    ); 

}

