<?php

class Vagas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Vagas_Db();
        $this->_title = 'Gerenciador de Vagas';
        $this->_singular = 'Vaga';
        $this->_plural = 'Vagas';
        $this->_layoutList = 'basic';
        $this->_primary = 'v.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from(array('v' => 'vagas'), array('id'))
                ->joinInner(array('c' => 'cidades'), 'v.cidade_id = c.id', array('id' => 'titulo'))
                ->order('titulo');
        return $db->fetchPairs($query);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'slug' => array(
                'type' => 'Hidden'
            ),
            'cidade_id' => array(
                'type' => 'Select',
                'label' => 'Cidade',
                'option' => Cidades_Model::fetchPair(),
                'required' => true,
            ),
            'titulo' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'vagas' => array(
                'type' => 'Number',
                'label' => 'Vagas',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'TextareaCkeditor',
                'label' => 'Descrição',
                'required' => true
            ),
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('v' => 'vagas'), array('*'))
                ->joinLeft(array('c' => 'cidades'), 'c.id = v.cidade_id', array('cidade' => 'nome'))
                ->order('v.titulo')
                ->group('v.id');
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'titulo' => 'Título',
            'cidade' => 'Cidade',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'titulo' => 'text',
            'descricao' => 'text'
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        if (!empty($data['titulo'])):
            $data['slug'] = WS_Text::slug($data['titulo']);
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

}
