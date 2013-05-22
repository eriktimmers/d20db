<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    public function _initView()
    {
        $doctypeHelper = new Zend_View_Helper_Doctype();
        $doctypeHelper->doctype('HTML5');       
    }
    
    public function _initRoute()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        

        $router->addRoute('gamesystem-crud', 
                          new Zend_Controller_Router_Route('gamesystem/:action/:id', array('controller' => 'gamesystem'))                
                );
        $router->addRoute('simpletable-crud', 
                          new Zend_Controller_Router_Route('simpletable/:type/:action/:id/', 
                                  array('controller' => 'simpletable'))                
                ); 
        $router->addRoute('controller-action-id', 
                          new Zend_Controller_Router_Route(':controller/:action/:id/')                
                );         
        $router->addRoute('simpletable-typeview', 
                          new Zend_Controller_Router_Route('simpletable/:type/:action/', 
                                  array('controller' => 'simpletable'))                
                );        
        $router->addRoute('simpletable-index', 
                          new Zend_Controller_Router_Route('simpletable/:type/', 
                                  array('controller' => 'simpletable',
                                        'action' => 'list'))                
                );        
       
                                
    }

}

