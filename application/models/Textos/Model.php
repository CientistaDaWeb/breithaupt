<?php

class Textos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Textos_Db();
        $this->_title = 'Gerenciador de Textos';
        $this->_singular = 'Texto';
        $this->_plural = 'Textos';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'titulo' => 'Título',
            'codigo' => 'Código',
            'url' => 'Url',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'titulo' => 'text',
            'texto' => 'text',
            'url' => 'text',
            'codigo' => 'text',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'cabecalho_id' => array(
                'type' => 'Select',
                'label' => 'Cabeçalho',
                'option' => array('' => 'Selecione...'),
                'options' => Cabecalhos_Model::fetchPair(),
                'required' => true
            ),
            'titulo' => array(
                'label' => 'Título',
                'type' => 'Text',
                'required' => true
            ),
            'texto' => array(
                'label' => 'Texto',
                'type' => 'TextareaCkeditor',
                'required' => true
            ),
            'codigo' => array(
                'label' => 'Código',
                'type' => 'Text',
                'required' => true
            ),
            'url' => array(
                'label' => 'URL',
                'type' => 'Text',
                'required' => true
            ),
        );
    }

    public function getByCodigo($codigo) {
        $sql = clone ($this->_basicSearch);
        $sql->where('codigo = ?', $codigo);
        return $sql->query()->fetch();
    }

}
