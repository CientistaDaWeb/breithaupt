<?php

class Erp_HistoricosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Historicos_Model();
        $this->form = WS_Form_Generator::generateForm('Historicos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                if ($_FILES['upload']['size'] > 0) {
                    $upload = new Upload($_FILES['upload']);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/historicos');
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