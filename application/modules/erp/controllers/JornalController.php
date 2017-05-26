<?php

class Erp_JornalController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Jornal_Model();
        $this->form = WS_Form_Generator::generateForm('Jornal', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                if ($_FILES['upload']['size'] > 0) {
                    $upload = new Upload($_FILES['upload']);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/jornal');
                        if ($upload->processed) {
                            $this->model->_params['imagem'] = $upload->file_dst_name;
                        } else {
                            $this->_helper->FlashMessenger(array('error' => $upload->error));
                        }
                    } else {
                        $this->_helper->FlashMessenger(array('error' => $upload->error));
                    }
                }
            endif;
        endif;
        parent::formularioAction();
    }

}