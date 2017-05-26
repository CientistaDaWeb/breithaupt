<?php

class Estado_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Estado_Db();
        $this->_title = 'Gerenciador de Estados';
        $this->_singular = 'Estado';
        $this->_plural = 'Estados';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('e' => 'estado'), array('nome', 'nome'))
                ->order("nome");
        return $db->fetchPairs($sql);
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Estado',
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

}
