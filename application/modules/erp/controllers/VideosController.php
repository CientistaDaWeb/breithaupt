<?php

class Erp_VideosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Videos_Model();
        $this->form = WS_Form_Generator::generateForm('Videos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}