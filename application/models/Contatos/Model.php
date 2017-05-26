<?php

class Contatos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Contatos_Db();
        $this->_title = 'Gerenciador de Contatos';
        $this->_singular = 'Contato';
        $this->_plural = 'Contatos';
        $this->_primary = 'c.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('c' => 'contatos'), array('id', 'nome'));
        return $db->fetchPairs($sql);
    }

    public function basicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->from(array('c' => 'contatos'), array('*'));
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'email' => 'E-mail',
            'cpf' => 'CPF',
            'estado' => 'Estado',
            'cidade' => 'Cidade',
            'telefone' => 'Telefone',
            'assunto' => 'Assunto',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
            'email' => 'text',
            'cpf' => 'cpf',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'email' => 'ASC',
            'nome' => 'ASC',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'label' => 'Nome',
                'type' => 'Text',
                'required' => true
            ),
            'cpf' => array(
                'label' => 'CPF',
                'type' => 'Text',
                'required' => true
            ),
            'email' => array(
                'label' => 'E-mail',
                'type' => 'Mail',
                'required' => true
            ),
            'estado' => array(
                'label' => 'Estado',
                'type' => 'Text',
                'required' => true
            ),
            'cidade' => array(
                'label' => 'Cidade',
                'type' => 'Text',
                'required' => true
            ),
            'telefone' => array(
                'label' => 'Telefone',
                'type' => 'Text',
                'required' => true
            ),
            'assunto' => array(
                'label' => 'Assunto',
                'type' => 'Text',
                'required' => true
            ),
            'criado' => array(
                'label' => 'Criado',
                'type' => 'Date',
                'required' => true
            ),
        );
    }

    public function verifica($email) {
        $sql = clone($this->_basicSearch);
        $sql->where('email = ? ', $email);
        $retorno = $sql->query()->fetch();
        return $retorno;
    }

}
