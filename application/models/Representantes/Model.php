<?php

class Representantes_Model extends WS_Model {

    protected $_tipo;

    public function __construct() {
        $this->_db = new Representantes_Db();
        $this->_title = 'Gerenciador de Representantes';
        $this->_singular = 'Representantes';
        $this->_plural = 'Representantes';
        $this->_layoutList = 'basic';
        $this->_primary = 'r.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from(array('r' => 'representantes'), array('id'))
                ->joinInner(array('c' => 'cidades'), 'r.cidade_id = c.id', array('loja' => 'CONCAT(c.nome," - ",l.nome)'))
                ->order('contato');
        return $db->fetchPairs($query);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'cidade_id' => array(
                'type' => 'Select',
                'label' => 'Cidade',
                'option' => Cidades_Model::fetchPair(),
                'required' => true,
            ),
            'contato' => array(
                'type' => 'Text',
                'label' => 'Contato',
                'required' => true
            ),
            'fone' => array(
                'type' => 'Text',
                'label' => 'Telefone',
                'required' => true
            ),
            'endereco' => array(
                'type' => 'Text',
                'label' => 'Endereco',
                'required' => true
            ),
            'email' => array(
                'type' => 'Mail',
                'label' => 'E-mail',
                'required' => true
            ),
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('r' => 'representantes'), array('*'))
                ->joinLeft(array('c' => 'cidades'), 'c.id = r.cidade_id', array('cidade' => 'nome'))
                ->group('r.id');
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'contato' => 'Nome',
            'cidade' => 'Cidade',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'conato' => 'text',
        );
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
