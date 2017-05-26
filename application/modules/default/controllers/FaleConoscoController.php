<?php

class Default_FaleConoscoController extends Default_Controller_Action {

    public function indexAction() {
        $form = new FaleConosco_Form();
        if ($this->_request->isPost()) :
            if ($form->isValid($this->_request->getPost())) :
                $ContatosModel = new Contatos_Model();
                $contato['nome'] = $this->_getParam('nome');
                $contato['cpf'] = $this->_getParam('cpf');
                $contato['email'] = $this->_getParam('email');
                $contato['estado'] = $this->_getParam('estado');
                $contato['cidade'] = $this->_getParam('cidade');
                $contato['telefone'] = $this->_getParam('telefone');
                $contato['assunto'] = $this->_getParam('assunto');
                $contato['criado'] = date('d/m/Y');
                $contato['created'] = date("Y-m-d H:i:s");

                if ($this->_getParam('receber')):
                    $verifica = $ContatosModel->verifica($contato['email']);
                    if (empty($verifica)):
                        $ContatosModel->_db->insert($contato);
                    else:
                        $where = $ContatosModel->_db->getDefaultAdapter()->quoteInto('email = ?', $contato['email']);
                        $ContatosModel->_db->update($contato, $where);
                    endif;
                endif;

                try {
                    $dados = $this->_request->getPost();
                    $nome = $dados['nome'];
                    $email = $dados['email'];

                    $mail = new WS_Email("UTF-8");

                    $this->view->conteudo = $dados;
                    $body = $this->view->render('emails/contato.phtml');

                    $configs = Zend_Registry::get('application');

                    $mail->setBodyHtml($body, 'UTF-8')
                            ->setSubject(utf8_decode($dados['assunto'] . ' - Contato enviado pelo site - ' . $configs->cliente->nome))
                            ->setFrom($email, $nome)
                            ->addTo($configs->cliente->email, $configs->cliente->nome)
                            //->addBcc($configs->cliente->email, $configs->cliente->nome)
                            ->setReplyTo($email)
                            ->Envia();
                    $this->_helper->FlashMessenger(array('sucess' => 'Mensagem enviada com sucesso. Agradecemos o seu contato e em breve daremos retorno!'));
                    $form->reset();
                    $this->_redirect('/fale-conosco');
                } catch (Zend_Mail_Exception $e) {
                    $this->_helper->FlashMessenger(array('error' => 'Erro ao enviar o e-mail - ' . $e->getMessage()));
                }
            else :
                $this->_helper->FlashMessenger(array('error' => 'Preencha todos os campos obrigatórios!'));
                $form->populate($this->_request->getPost())->markAsError();
            endif;
        endif;
        $this->view->form = $form;
    }

    public function cadastranewsAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if ($this->_request->isPost()) :
            if ($this->_getParam('nome') && $this->_getParam('email')):
                $ContatosModel = new Contatos_Model();
                $contato['nome'] = $this->_getParam('nome');
                $contato['email'] = $this->_getParam('email');
                $contato['criado'] = date('d/m/Y');
                $contato['created'] = date("Y-m-d H:i:s");

                $verifica = $ContatosModel->verifica($contato['email']);
                if (empty($verifica)):
                    $ContatosModel->_db->insert($contato);
                else:
                    $where = $ContatosModel->_db->getDefaultAdapter()->quoteInto('email = ?', $contato['email']);
                    $ContatosModel->_db->update($contato, $where);
                endif;
                echo '<script>$.jGrowl("E-mail cadastrado com sucesso!", { theme: "sucess", life: 10000 });</script>';
            else:
                echo '<script>$.jGrowl("Prencha todos os campos para cadastrar-se em nossa lista de newsletter!", { theme: "error", life: 10000 });</script>';
            endif;
        endif;
        exit();
    }

}
