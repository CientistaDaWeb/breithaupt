<?php

class Cidades_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Cidades_Db();
        $this->_title = 'Gerenciador de Cidades';
        $this->_singular = 'Cidade';
        $this->_plural = 'Cidades';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('c' => 'cidades'), array('id', 'nome'))
                ->order("nome");
        return $db->fetchPairs($sql);
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Cidade',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'label' => 'Cidade',
                'type' => 'Text',
                'required' => true
            ),
        );
    }
    public function buscaComCurso(){
        $sql = clone($this->_basicSearch);
        $sql->joinInner(array('c' => 'cursos'), 'c.cidade_id = cidades.id', array(''));
        return $sql->query()->fetchAll();
    }

}
