<?php

class Noticias_Model extends WS_Model {

    protected $_destaque;

    public function __construct() {
        $this->_db = new Noticias_Db();
        $this->_title = 'Gerenciador de Notícias';
        $this->_singular = 'Notícia';
        $this->_plural = 'Notícias';
        $this->_layoutList = 'basic';
        $this->_destaque = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        parent::__construct();
        parent::turningFemale();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'slug' => array(
                'type' => 'Slug'
            ),
            'imagem' => array(
                'type' => 'Slug'
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Data',
                'required' => true
            ),
            'titulo' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'texto' => array(
                'type' => 'TextareaCkeditor',
                'label' => 'Texto',
                'required' => true
            ),
            'destaque' => array(
                'type' => 'Select',
                'label' => 'Em Destaque?',
                'options' => $this->_destaque,
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
            'destaque' => 'getOption'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data' => 'Data',
            'titulo' => 'Título',
            'destaque' => 'Destaque',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'titulo' => 'text',
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
        $sql->order('data DESC')
                ->order('destaque DESC');
        $adapter = new Zend_Paginator_Adapter_DbSelect($sql);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }

    public function destaques() {
        $sql = clone($this->_basicSearch);
        $sql->where('destaque = ?', 'S')
                ->order('data DESC')
                ->limit(5);

        return $sql->query()->fetchAll();
    }

    public function getBySlug($slug) {
        $sql = clone($this->_basicSearch);
        $sql->where('slug = ?', $slug);
        return $sql->query()->fetch();
    }

}