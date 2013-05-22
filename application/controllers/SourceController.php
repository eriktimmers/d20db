<?php

class SourceController extends Zend_Controller_Action
{

    public function init()
    {
        
        $this->table = new Application_Model_Source();         
            
        $this->view->headTitle('Sources');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-sources available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/sources.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('Source');
        
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        
        $soureTypeModel = new Application_Model_SimpleTable('sourcetypes');
        $gameSystemModel = new Application_Model_Gamesystem();
        $worldModel = new Application_Model_SimpleTable('worlds');
        $formConfig = array('types'       => $soureTypeModel->getList(),
                            'gamesystems' => $gameSystemModel->getList(),
                            'worlds'      => $worldModel->getList(),
            );        
        $form = new Application_Form_Sourcefilter($formConfig);
        
        if ($request->isPost()) {
            $form->isValid($request->getParams());
            $this->session->filter = $form->getValues();
        } else {
            $form->populate((array)$this->session->filter);
        }
        
        $this->view->form = $form; 
        
        $this->view->list = $this->table->all($form->getValues());
        
    }

    public function viewAction()
    {
        $this->view->id = (int)$this->getRequest()->getParam('id');
        $this->view->item = $this->table->find($this->view->id);
    }
    
    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');
        
        $soureTypeModel = new Application_Model_SimpleTable('sourcetypes');
        $gameSystemModel = new Application_Model_Gamesystem();
        $worldModel = new Application_Model_SimpleTable('worlds');
        $formConfig = array('types'       => $soureTypeModel->getList(),
                            'gamesystems' => $gameSystemModel->getList(),
                            'worlds'      => $worldModel->getList(),
            );
        
        $form = new Application_Form_Source($formConfig);        
        
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $this->table->save($id, $form->getValues());
                return $this->_helper->getHelper('Redirector')
                                     ->gotoSimple('index', 'source');                
            }
        }
        
        if ($id) {
            $this->view->title = 'Edit Source';
            $data = $this->table->find($id);
            $form->populate($data);
            
        } else {
            $this->view->title = 'New Source';           
        
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
    
    
}

