<?php

class Erp_TextosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Textos_Model();
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()):
            $user = $auth->getIdentity();
            if ($user->papel == 'U'):
                $this->model->_formFields['codigo']['type'] = 'Hidden';
                $this->model->_formFields['url']['type'] = 'Hidden';
            endif;
        endif;
        $this->form = WS_Form_Generator::generateForm('Textos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}
