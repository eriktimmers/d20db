<?php

class GamesystemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->table = new Application_Model_Gamesystem();        
        $this->controller = $this->getRequest()->getControllerName();
        
        $this->view->inlineScript()->appendFile(
                    '/js/gamesystemcontroller.js',
                    'text/javascript');
        
        $this->view->headTitle('Gamesystems');
        
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all gamesystems available');
        
    }

    public function indexAction()
    {   
        $this->view->systems = array_map(function($partialArray) {
                return array_merge($partialArray, array("controllerBasePath" => "/gamesystem/"));
        }, $this->table->all());
    }

    public function editAction()
    {
                        
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');
        $form    = new Application_Form_Name(array('fieldprefix' => 'sys_'));
 
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $this->table->save($id, $form->getValues());
                return $this->_helper->redirector()->gotoSimple('index', 'gamesystem');
            }
        }
 
        if ($id) {
            $this->view->title = 'Edit Gamesystem';
            $data = $this->table->find($id);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Gamesystem';            
        
        }                
        
        $this->view->form = $form;        
    }

    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->delete($id);
    }    

    public function viewAction()
    {
        $this->view->id = (int)$this->getRequest()->getParam('id');
        $this->view->item = $this->table->find($this->view->id);
    }    
    
    
    
}

