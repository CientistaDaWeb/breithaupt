<?php

class FaleConosco_Form extends Zend_Form {

    public function init() {

        $assuntos = array(
            'Sugestões' => 'Sugestões',
            'Reclamações' => 'Reclamações',
            'Cotação' => 'Cotação',
            'Entregas' => 'Entregas',
            'Outras Dúvidas' => 'Outras Dúvidas'
        );

        $this->setAttrib('id', 'fale-conosco-form')
                ->setAction('fale-conosco')
                ->setMethod('post');
        $this->addElement('text', 'nome', array(
            'label' => 'Nome Completo (*)',
            'required' => true
        ));
        $this->addElement('text', 'cpf', array(
            'label' => 'CPF (*)',
            'required' => true
        ));
        $this->addElement('text', 'email', array(
            'label' => 'E-mail (*)',
            'required' => true,
            'validators' => array(
                'EmailAddress'
            )
        ));
        $this->addElement('text', 'telefone', array(
            'label' => 'Telefone de Contato (*) <small>Ex: (47) 1234-1234</small>',
            'required' => true,
        ));
        $this->addElement('select', 'estado', array(
            'label' => 'Estado (*)',
            'required' => true
        ));
        $this->getElement('estado')
                ->addMultiOption('', 'Selecione...')
                ->addMultiOptions(Estado_Model::fetchPair());

        $this->addElement('select', 'cidade', array(
            'label' => 'Cidade (*)',
            'required' => true,
            'multiOptions' => Cidade_Model::fetchPair(),
        ));
        $this->addElement('select', 'loja', array(
            'label' => 'Home Center e Lojas (*)',
            'required' => false,
            'multiOptions' => Lojas_Model::fetchPair()
        ));
        $this->addElement('select', 'assunto', array(
            'label' => 'Assunto (*)',
            'required' => true,
            'multiOptions' => $assuntos
        ));
        $this->addElement('textarea', 'mensagem', array(
            'label' => 'Mensagem (*)',
            'rows' => '7',
            'cols' => '35',
            'required' => true
        ));
        $this->addElement('checkbox', 'receber', array(
            'label' => 'Receba nossas novidades.',
            'required' => false
        ));
        $this->addElement('button', 'enviar', array(
            'ignore' => true,
            'label' => 'Enviar',
        ));
        $this->getElement('enviar')->removeDecorator('label')->removeDecorator('DtDdWrapper')->setAttrib('type', 'submit');
    }

}
