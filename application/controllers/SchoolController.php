<?php

class SchoolController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_SchoolService();      
            
        $this->view->headTitle('Spell Schools');
        $this->view->HeadMeta()->appendName('description', 'Overview and details of all RPG-spell schools available');              
        
        $this->view->inlineScript()->appendFile(
                    '/js/schools.js',
                    'text/javascript');
        
        $this->session = new Zend_Session_Namespace('School');
    }

    public function indexAction()
    {
        $this->view->list = $this->table->all();
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');
        
        $form = new Application_Form_School();          
        
        if ($request->isPost()) {
            
            $post = $request->getPost();
            
            if ($form->isValid($post)) {
                $id = $this->table->saveSchool($id, $form->getValues());
                
                $this->_helper->redirector()->gotoSimple('school', 'index');
            }

        }
        
        
        if ($id) {
            $data = $this->table->findSchool($id);
            $form->populate($data);
        }         
        
        $this->view->form = $form;
        
    }

    public function subschoolAction()
    {
        $request = $this->getRequest();
        $id = (int)$request->getParam('id');        
        
        $formConfig = array('schools' => $this->table->getListSchools());
        $form = new Application_Form_Subschool($formConfig);
        
        if ($request->isPost()) {
            $post = $request->getPost();
            if ($form->isValid($post)) {
                $id = $this->table->saveSubschool($id, $form->getValues());
                $this->_helper->redirector()->gotoSimple('school', 'index');
            }

        }
        
        
        if ($id) {
            $data = $this->table->findSubschool($id);
            $form->populate($data);
        }         
                
        $this->view->form = $form;          
    }

    public function subschooldeleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->subschoolDelete($id);
    }

    public function schooldeleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $id = (int)$this->getRequest()->getParam('id'); 
        $this->table->schoolDelete($id);
    }


}









