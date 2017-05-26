<?php

class Cursos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Cursos_Db();
        $this->_title = 'Gerenciador de Cursos';
        $this->_singular = 'Curso';
        $this->_plural = 'Cursos';
        $this->_layoutList = 'basic';
        $this->_primary = 'c.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from(array('c' => 'cursos'), array('id', 'nome'))
                ->order('nome');
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
            'local' => array(
                'type' => 'Text',
                'label' => 'Local',
                'required' => true
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Date de Início',
                'required' => true
            ),
            'nome' => array(
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
                ->from(array('c' => 'cursos'), array('*'))
                ->joinLeft(array('ci' => 'cidades'), 'ci.id = c.cidade_id', array('cidade' => 'nome'))
                ->order('c.data')
                ->group('c.id');
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Título',
            'cidade' => 'Cidade',
            'data' => 'Data',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
            'descricao' => 'text',
            'local' => 'text',
            'cidade' => 'text',
            'data' => 'date',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date'
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        if (!empty($data['nome'])):
            $data['slug'] = WS_Text::slug($data['nome']);
        endif;
        return parent::adjustToDb($data);
    }

    public function getBySlug($slug) {
        $sql = clone($this->_basicSearch);
        $sql->where('c.slug = ?', $slug);
        return $sql->query()->fetch();
    }

    public function buscaPorCidade($cidade){
        $sql = clone($this->_basicSearch);
        $sql->where('ci.id = ?', $cidade);
        return $sql->query()->fetchAll();
    }

}
