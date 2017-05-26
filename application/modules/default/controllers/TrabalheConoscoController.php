<?php

class Default_TrabalheConoscoController extends Default_Controller_Action {

    public function indexAction() {
        $form = new TrabalheConosco_Form();
        if ($this->_request->isPost()) :
            if ($form->isValid($this->_request->getPost())) :
                $ContatosModel = new Contatos_Model();
                $contato['nome'] = $this->_getParam('nome');
                $contato['email'] = $this->_getParam('email');
                $contato['created'] = date("Y-m-d H:i:s");

                $verifica = $ContatosModel->verifica($contato['email']);
                if (empty($verifica)):
                    $ContatosModel->_db->insert($contato);
                else:
                    $where = $ContatosModel->_db->getDefaultAdapter()->quoteInto('email = ?', $contato['email']);
                    $ContatosModel->_db->update($contato, $where);
                endif;
                try {
                    $dados = $this->_request->getPost();
                    $nome = $dados['nome'];
                    $email = $dados['email'];

                    $mail = new WS_Email("utf-8");

                    if ($_FILES):
                        $arqTmp = $_FILES["curriculo"]["tmp_name"];
                        $arqName = $_FILES["curriculo"]["name"];
                        $arqType = $_FILES["curriculo"]["type"];

                        $mail->createAttachment(file_get_contents($arqTmp), $arqType, Zend_Mime::DISPOSITION_INLINE, Zend_Mime::ENCODING_BASE64, $arqName);
                    endif;

                    $this->view->conteudo = $dados;
                    $body = $this->view->render('emails/trabalheconosco.phtml');

                    $configs = Zend_Registry::get('application');

                    $mail->setBodyHtml($body, 'utf-8')
                            ->setSubject(utf8_decode('Currículo enviado pelo site - ' . $configs->cliente->nome))
                            ->setFrom($email, $nome)
                            ->addTo($configs->cliente->email, $configs->cliente->nome)
                            //->addTo('th.recrutamento@breithaupt.com.br')
                            ->setReplyTo($email)
                            ->Envia();
                    $this->_helper->FlashMessenger(array('sucess' => 'Mensagem enviada com sucesso. Agradecemos o seu contato e em breve daremos retorno!'));
                    $form->reset();
                } catch (Zend_Mail_Exception $e) {
                    $this->_helper->FlashMessenger(array('error' => 'Erro ao enviar o e-mail - ' . $e->getMessage()));
                }
            else :
                $this->_helper->FlashMessenger(array('error' => 'Preencha todos os campos obrigatórios!'));
                $form->populate($this->_request->getPost())->markAsError();
            endif;
        endif;
        $VagasModel = new Vagas_Model();
        $vagas = $VagasModel->listagem();
        $this->view->vagas = $vagas;

        if (($this->hasParam('slug'))):
            $slug = $this->_getParam('slug');
            $item = $VagasModel->getBySlug($slug);
            if (!empty($item)):
                $this->view->item = $item;
            endif;
            $form->setAction('trabalhe-conosco/' . $slug);
        endif;

        $this->view->form = $form;
    }

    public function pegacidadesAction() {
        $this->_helper->layout()->disableLayout();
        $estado = $this->_getParam('uf');
        if (!empty($estado)):
            $CidadeModel = new Cidade_Model();
            $items = $CidadeModel->getByEstado($estado);
            $retorno = array();
            foreach ($items AS $id => $item):
                $retorno[$item] = $id;
            endforeach;
            echo Zend_Json::encode($retorno);
        endif;
        exit();
    }

}
