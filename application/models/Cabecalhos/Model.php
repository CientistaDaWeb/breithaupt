<?php

class Cabecalhos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Cabecalhos_Db();
        $this->_title = 'Gerenciador de Cabeçalhos';
        $this->_singular = 'Cabeçalho';
        $this->_plural = 'Cabeçalhos';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('c' => 'cabecalhos'), array('id', 'codigo'))
                ->order("codigo");
        return $db->fetchPairs($sql);
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
            'codigo' => array(
                'type' => 'Text',
                'label' => 'Código',
                'required' => true
            ),
            'titulo' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'subtitulo' => array(
                'type' => 'Text',
                'label' => 'Subtítulo',
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

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'cabecalhos'), array('*'));
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'slug' => 'slug',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'codigo' => 'Código',
            'titulo' => 'Título',
            'subtitulo' => 'Subtítulo',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'titulo' => 'text',
            'subtitulo' => 'text',
            'codigo' => 'text',
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        if (!empty($data['codigo'])):
            $data['slug'] = $data['codigo'];
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

    public function getBySlug($slug) {
        $sql = clone($this->_basicSearch);
        $sql->where('slug = ?', $slug);
        return $sql->query()->fetch();
    }

    public function buscaPorTexto($slug) {
        $sql = clone($this->_basicSearch);
        $sql->joinInner(array('t' => 'textos'), 't.cabecalho_id = c.id', array(''));
        $sql->where('t.codigo = ?', $slug);
        return $sql->query()->fetch();
    }

}
