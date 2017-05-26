<?php

class Erp_VagasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Vagas_Model();
        $this->form = WS_Form_Generator::generateForm('Vagas', $this->model->getFormFields());
        parent::init();
    }

}