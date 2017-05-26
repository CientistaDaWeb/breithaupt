<?php

class TrabalheConosco_Form extends Zend_Form {

    public function init() {

        $this->setAttrib('id', 'trabalhe-conosco-form')
                ->setAction('trabalhe-conosco')
                ->setEnctype('multipart/form-data')
                ->setMethod('POST');

        $this->addElement('text', 'nome', array(
            'label' => 'Nome Completo (*)',
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
            'label' => 'Telefone (*)',
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
        $this->addElement('hidden', 'vaga', array(
            'required' => true,
        ));
        $this->addElement('file', 'curriculo', array(
            'label' => 'Anexar Currículo (*)',
            'required' => true,
        ));
        $this->getElement('curriculo')
                ->addValidator('Extension', false, 'pdf,doc,docx,txt')
                ;

        $this->addElement('textarea', 'observacao', array(
            'label' => 'Observação',
            'rows' => '7',
            'cols' => '35',
        ));
        $this->addElement('checkbox', 'receber', array(
            'label' => 'Deseja Receber Novidades do Breithaupt em meu e-mail.',
        ));
        $this->addElement('button', 'enviar', array(
            'ignore' => true,
            'label' => 'Enviar',
        ));
        $this->getElement('enviar')->removeDecorator('label')->removeDecorator('DtDdWrapper')->setAttrib('type', 'submit');
    }

}
