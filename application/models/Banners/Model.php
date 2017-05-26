<?php

class Banners_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Banners_Db();
        $this->_title = 'Gerenciador de Banners';
        $this->_singular = 'Banner';
        $this->_plural = 'Banners';
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
            'ordem' => array(
                'type' => 'Number',
                'label' => 'Ordem',
                'required' => true
            ),
            'url' => array(
                'type' => 'Url',
                'label' => 'Url',
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
            'url' => 'Url',
            'ordem' => 'Ordem',
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

    public function listByHome() {
        $sql = clone($this->_basicSearch);
        $sql->order('ordem ASC');
                //->limit(4);
        return $consulta = $sql->query()->fetchAll();
    }

}
