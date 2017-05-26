<?php

class Erp_ContatosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Contatos_Model();
        $this->form = WS_Form_Generator::generateForm('Contatos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        $items = $this->model->listagem();
        $this->view->items = $this->model->_items = $items;

        parent::indexAction();
    }

    public function exportarAction() {
        $listagem = $this->model->listagem();
        if (!empty($listagem)):
            foreach ($listagem AS $contato):
                $linhas[] = $contato['nome'] . ';' . $contato['email'] . ';' . utf8_decode($contato['estado']) . ';' . utf8_decode($contato['cidade']) . ';' . $contato['telefone'] . ';' . utf8_decode($contato['assunto']). ';' . nl2br(utf8_decode($contato['mensagem'])) . ';' . $contato['criado'];
            endforeach;
            $arquivo = UPLOAD_PATH . 'contatos.csv';
            $WF = new WS_File();
            $WF->remove($arquivo);
            $WF->create($arquivo, $linhas);
            header("Content-type: text/csv");
            header("Content-disposition: attachment; filename=contatos.csv");
            readfile($arquivo);
        endif;
        exit();
    }

}
