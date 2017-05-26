<?php

class Videos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Videos_Db();
        $this->_title = 'Gerenciador de Videos';
        $this->_singular = 'Video';
        $this->_plural = 'Videos';
        $this->_layoutList = 'basic';
        $this->_layoutForm = 'basic';

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'video' => array(
                'type' => 'Url',
                'label' => 'Video',
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
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'video' => 'Video',
            'data_inicio' => 'Data Inicial',
            'data_fim' => 'Data Final',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_inicio' => 'date',
            'data_fim' => 'date'
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        return parent::adjustToDb($data);
    }

    public function getVideo() {
        $sql = clone($this->_basicSearch);
        $sql->where('data_inicio <= ?', date('Y-m-d'))
                ->where('data_fim >= ?', date('Y-m-d'))
                ->order('data_inicio DESC')
                ->limit(1);
        return $consulta = $sql->query()->fetch();
    }

}
