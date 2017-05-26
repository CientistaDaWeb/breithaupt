<?php

class Default_EmpresaController extends Default_Controller_Action {

    public function indexAction() {

    }

    public function apresentacaoAction() {

    }

    public function historicoAction() {
        $HistoricosModel = new Historicos_Model();
        $historicos = $HistoricosModel->listagem();
        $this->view->historicos = $historicos;
    }

    public function buscahistoricoAction() {
        $this->_helper->layout()->disableLayout();
        $year = $this->_getParam('year');
        $HistoricosModel = new Historicos_Model();
        $this->view->historico = $HistoricosModel->findByYear($year);
    }

    public function missaoVisaoEValoresAction() {

    }

}
