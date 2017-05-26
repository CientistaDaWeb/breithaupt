<?php

class Historicos_Model extends WS_Model {

    protected $_destaque;

    public function __construct() {
        $this->_db = new Historicos_Db();
        $this->_title = 'Gerenciador de Históricos';
        $this->_singular = 'Histórico';
        $this->_plural = 'Históricos';
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
            'ano' => array(
                'type' => 'Number',
                'label' => 'Ano',
                'required' => true
            ),
            'texto' => array(
                'type' => 'TextareaCkeditor',
                'label' => 'Texto',
                'required' => true
            ),
            'upload' => array(
                'type' => 'File',
                'label' => 'Imagem',
            ),
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'slug' => 'slug',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'ano' => 'Ano',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'ano' => 'text',
            'texto' => 'text'
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        if (!empty($data['titulo'])):
            $data['slug'] = $data['titulo'];
        endif;
        return parent::adjustToDb($data);
    }

    public function paginada($page) {
        $sql = clone($this->_basicSearch);

        $paginator = $this->paginator($sql, $page);
        return $paginator;
    }

    public function paginator($sql, $page) {
        $sql->order('data DESC');
        $adapter = new Zend_Paginator_Adapter_DbSelect($sql);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }

    public function findByYear($year) {
        $sql = clone($this->_basicSearch);
        $sql->where('ano = ?', $year);
        return $sql->query()->fetch();
    }

}
