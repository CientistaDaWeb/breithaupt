<?php

class Erp_PromocoesPaginasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new PromocoesPaginas_Model();
        $this->form = WS_Form_Generator::generateForm('PromocoesPaginas', $this->model->getFormFields());
        parent::init();
    }

    public function paginaAction() {
        $promocao_id = $this->_request->getParam('parent_id');
        $items = $this->model->buscarPorPromocao($promocao_id);
        $this->view->items = $items;
        $this->view->promocao_id = $promocao_id;
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function uploadAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $auth = new WS_Auth('erp');
        $dados = array();
        $dados['promocao_id'] = $this->_getParam('promocao_id');
        $dados['created'] = date('Y-m-d H:i:s');
        if ($this->_request->isPost()):
            if (!empty($_FILES)) {
                foreach ($_FILES AS $ARQUIVO) :
                    $upload = new Upload($ARQUIVO);
                    if ($upload->uploaded) {
                        $upload->Process(UPLOAD_PATH . '/promocoes/');
                        if ($upload->processed) {
                            $dados['imagem'] = $upload->file_dst_name;
                            $dados['ordem'] = intval($upload->file_dst_name) * 10;

                            $this->model->_db->insert($dados, $this->model->getOption('messages', 'add'), $this->model->_db->getTableName());
                            $sucesso = true;
                        } else {
                            //$this->_helper->FlashMessenger(array('error' => $upload->error));
                            echo $upload->error;
                        }
                    } else {
                        //$this->_helper->FlashMessenger(array('error' => $upload->error));
                        echo $upload->error;
                    }
                endforeach;
            } else {
                //$this->_helper->FlashMessenger(array('error' => 'Nenhuma imagem selecionada!'));
                echo 'Nenhuma imagem selecionada!';
            }
            if (isset($sucesso)):
                echo '1';
            endif;
        else:
            echo 'Formul&aacute;rio n&atilde;o enviado corretamente!';
        endif;
        exit();
    }

}
