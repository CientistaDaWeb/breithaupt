<?php

class BannersFlutuantes_Model extends WS_Model {

    public function __construct() {
        $this->_db = new BannersFlutuantes_Db();
        $this->_title = 'Gerenciador de Banners Flutuantes';
        $this->_singular = 'Banner Flutuante';
        $this->_plural = 'Banners Flutuantes';
        $this->_layoutList = 'basic';

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
            'link' => array(
                'type' => 'Url',
                'label' => 'Link',
            ),
            'upload' => array(
                'type' => 'File',
                'label' => 'Imagem (800x500)',
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'link' => 'Link',
            'imagem' => 'Imagem',
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
            'data_fim' => 'date',
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        return parent::adjustToDb($data);
    }

    public function adjustToView(array $data) {
        $data['imagem'] = '<a href="/storage/imagem/' . $data['imagem'] . '/banners_flutuantes?w=800&h=500&c=crop" target="_blank"><img src="/storage/imagem/' . $data['imagem'] . '/banners_flutuantes?w=100&h=50&c=crop" /></a>';
        return parent::adjustToView($data);
    }

    public function getBanner() {
        $sql = clone($this->_basicSearch);
        $sql->where('data_inicio <= ?', date('Y-m-d'))
                ->where('data_fim >= ?', date('Y-m-d'))
                ->order('data_inicio DESC')
                ->limit(1);
        return $consulta = $sql->query()->fetch();
    }

}
