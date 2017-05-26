<?php

class Default_NossasLojasController extends Default_Controller_Action {

    public function init() {
        $this->model = new Lojas_Model();
        parent::init();
    }

    public function indexAction() {
        $lojas = $this->model->listaLojas();
        foreach ($lojas AS $loja):
            $retorno[$loja['cidade']][] = $loja;
        endforeach;
        $administracao = $this->model->listaAdministracao();
        $this->view->lojas = $retorno;
        $this->view->administracao = $administracao;
    }

    public function buscaAction() {
        $id = $this->_getParam('id');
        $this->_helper->layout()->disableLayout();
        $this->view->loja = $this->model->find($id);
    }

    public function localizacaoAction() {
        $id = $this->_getParam('id');
        $this->_helper->layout()->disableLayout();
        if ($id != 'administracao' || $id != 'centrais'):
            $loja = $this->model->find($id);
            echo Zend_Json::encode($loja);
        endif;
        exit();
    }

}
