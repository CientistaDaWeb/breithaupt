<?php

class Default_Controller_Action extends Zend_Controller_Action {

    public function init() {
        parent::init();

        $TextosModel = new Textos_Model();
        $this->view->TextosModel = $TextosModel;

        $CabecalhosModel = new Cabecalhos_Model();
        $this->view->CabecalhosModel = $CabecalhosModel;

    }

}