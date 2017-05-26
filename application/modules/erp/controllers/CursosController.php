<?php

class Erp_CursosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Cursos_Model();
        $this->form = WS_Form_Generator::generateForm('Cursos', $this->model->getFormFields());
        parent::init();
    }

}