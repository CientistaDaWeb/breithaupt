<?php

class Erp_CidadesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Cidades_Model();
        $this->form = WS_Form_Generator::generateForm('Cidades', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}