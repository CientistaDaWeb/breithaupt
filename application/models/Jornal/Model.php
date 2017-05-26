<?php

class Jornal_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Jornal_Db();
        $this->_title = 'Gerenciador de Jornais de Ofertas';
        $this->_singular = 'Jornal de Ofertas';
        $this->_plural = 'Jornais de Ofertas';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'imagem' => array(
                'type' => 'Slug'
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'data_inicio' => array(
                'type' => 'Date',
                'label' => 'Data Inicial',
                'required' => true
            ),
            'data_fim' => array(
                'type' => 'Date',
                'label' => 'Data Final',
                'required' => true
            ),
            'upload' => array(
                'type' => 'File',
                'label' => 'Imagem',
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'data_inicio' => 'Data Inicial',
            'data_fim' => 'Data Final',
            'preview' => 'Preview'
        );
    }
    public function setOrderFields() {
        $this->_orderFields = array(
            'data_inicio' => 'DESC'
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_inicio' => 'date',
            'data_fim' => 'date',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        return parent::adjustToDb($data);
    }

    public function getJornal() {
        $sql = clone($this->_basicSearch);
        $sql->where('data_inicio <= ?', date('Y-m-d'))
                ->where('data_fim >= ?', date('Y-m-d'))
                ->order('data_inicio DESC')
                ->limit(1);
        return $consulta = $sql->query()->fetch();
    }

    public function adjustToView(array $data) {
        $data['preview'] = '<a class="buttonLink" href="/caderno-ofertas/'.$data['id'].'" target="_blank">Preview</a>';
        return parent::adjustToView($data);
    }

}
