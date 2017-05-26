<?php

class Lojas_Model extends WS_Model {

    protected $_tipo;

    public function __construct() {
        $this->_db = new Lojas_Db();
        $this->_title = 'Gerenciador de Lojas';
        $this->_singular = 'Loja';
        $this->_plural = 'Lojas';
        $this->_layoutList = 'basic';
        $this->_primary = 'l.id';

        $this->_tipo = array(
            'L' => 'Loja',
            'A' => 'Administração'
        );

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from(array('l' => 'lojas'), array('id'))
                ->joinInner(array('c' => 'cidades'), 'l.cidade_id = c.id', array('loja' => 'CONCAT(c.nome," - ",l.nome)'))
                ->order('loja');
        return $db->fetchPairs($query);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'imagem' => array(
                'type' => 'Slug'
            ),
            'cidade_id' => array(
                'type' => 'Select',
                'label' => 'Cidade',
                'option' => Cidades_Model::fetchPair(),
                'required' => true,
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Título',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'TextareaCkeditor',
                'label' => 'Descrição',
                'required' => true
            ),
            'longitude' => array(
                'type' => 'Text',
                'label' => 'Longitude, Latitude',
                'required' => true
            ),
            'tipo' => array(
                'type' => 'Select',
                'label' => 'Loja / Administração',
                'options' => $this->_tipo,
                'required' => 'true',
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
                ->from(array('l' => 'lojas'), array('*'))
                ->joinLeft(array('c' => 'cidades'), 'c.id = l.cidade_id', array('cidade' => 'nome'))
                ->group('l.id');
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'cidade' => 'Cidade',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'l.nome' => 'text',
            'c.nome' => 'text',
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

    public function listaLojas() {
        $sql = clone($this->_basicSearch);
        $sql->where('tipo = ?', 'L');
        return $sql->query()->fetchAll();
    }

    public function listaAdministracao() {
        $sql = clone($this->_basicSearch);
        $sql->where('tipo = ?', 'A');
        return $sql->query()->fetchAll();
    }

    public function getBySlug($slug) {
        $sql = clone($this->_basicSearch);
        $sql->where('slug = ?', $slug);
        return $sql->query()->fetch();
    }

}
