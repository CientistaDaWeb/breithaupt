<?php

class Erp_RepresentantesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Representantes_Model();
        $this->form = WS_Form_Generator::generateForm('Representantes', $this->model->getFormFields());
        parent::init();
    }

}
