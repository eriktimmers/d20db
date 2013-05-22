<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
                
        $this->session = new Zend_Session_Namespace('SystemFilter');
        
        if (!is_object($this->session->filter)) {
            $this->session->filter = new Application_Model_SystemFilter();             
        }

    }

    public function indexAction()
    {
        // action body

    }

    public function filterSystemAction()
    {
        $request = $this->getRequest();
        
        // create the form
        $SystemsModel = new Application_Model_SimpleTable('gamesystems');
        $formConfig = array('Systems' => $SystemsModel->getList());        
        $form = new Application_Form_SystemFilter($formConfig);
        
        // handle form post or populate
        if ($request->isPost()) {
            $form->isValid($request->getParams());
            $this->session->filter->setFormValues($form->getValues());
            return $this->_helper->redirector()->gotoSimple('index', 'index');
            
            
        } else {
            $form->populate((array)$this->session->filter->getFormValues());
        }        
        
        $this->view->form = $form; 
    }


}



