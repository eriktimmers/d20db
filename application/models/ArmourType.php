<?php

class Application_Model_ArmourType
{

    public function getList()
    {
        return array('Light' => 'Light',
                     'Medium' => 'Medium',
                     'Heavy' => 'Heavy',
                     'Shield' => 'Shield',
                     'Other' => 'Other'
                     );
        
    }
    
}

