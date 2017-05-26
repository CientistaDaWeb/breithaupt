<?php

class Cidade_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Cidade_Db();
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
                ->from(array('c' => 'cidade'), array('nome', 'nome'))
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
            'estado' => array(
                'label' => 'Estado',
                'type' => 'Select',
                'required' => true,
                'options' => Estado_Model::fetchPair(),
            ),
        );
    }

    public function getByEstado($uf) {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('c' => 'cidade'), array('nome', 'nome'))
                ->joinInner(array('e' => 'estado'), 'e.id = c.estado', array(''))
                ->order("nome")
                ->where('e.nome = ?', $uf);
        return $db->fetchPairs($sql);
    }

}
