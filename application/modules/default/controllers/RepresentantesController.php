<?php

class Default_RepresentantesController extends Default_Controller_Action {

    public function indexAction() {
        $this->_helper->layout()->disableLayout();
        $RepresentatesModel = new Representantes_Model();
        $representantes = $RepresentatesModel->listagem();
        foreach ($representantes AS $item):
            $retorno[$item['cidade']][] = $item;
        endforeach;
        $this->view->representantes = $retorno;
    }

}
