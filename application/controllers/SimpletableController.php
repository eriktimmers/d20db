<?php

class SimpletableController extends Zend_Controller_Action
{

    protected $type;
    protected $table;


    public function init()
    {
        $this->type = $this->getRequest()->getParam('type');
        if ($this->type) {
            $this->table = new Application_Model_SimpleTable($this->type);        
            $this->view->type = $this->type;
            $this->view->prefix = $this->table->getPrefix();
            $this->view->linkPrefix = '/simpletable/' . $this->type . '/';
            
            $this->view->headTitle(ucfirst($this->type));
            $this->view->HeadMeta()->appendName('description', 'Overview and details of all ' . $this->type . ' available');              
        }
        
        $this->view->inlineScript()->appendFile(
                    '/js/simpletable.js',
                    'text/javascript');     
    }

    public function indexAction()
    {
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');
        $form = new Application_Form_Name(array('fieldprefix' => $this->table->getPrefix()));
 
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $this->table->save($id, $form->getValues());
                return $this->_helper->getHelper('Redirector')
                                     ->gotoRoute(
                                            array('type' => $this->type),
                                            'simpletable-index'
                                            );                
            }
        }
 
        if ($id) {
            $this->view->title = 'Edit ' . ucfirst(substr($this->type, 0, -1));
            $data = $this->table->find($id);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New' . ucfirst(substr($this->type, 0, -1));           
        
        }                
        
        $this->view->form = $form; 
    }
    
    public function listAction()
    {        
        $this->view->list = $this->table->all(); 
        
    }    
    
    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->delete($id);
    }   
    
}

