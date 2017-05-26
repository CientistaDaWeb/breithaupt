<?php

class PromocoesPaginas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new PromocoesPaginas_Db();
        $this->_title = 'Gerenciador de Páginas de Promoções';
        $this->_singular = 'Página de Promoções';
        $this->_plural = 'Páginas de Promoções';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'promocao_id' => array(
                'type' => 'Hidden'
            ),
            'ordem' => array(
                'type' => 'Text',
                'label' => 'Ordem',
                'required' => true
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'imagem' => 'Imagem',
            'ordem' => 'Ordem',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'imagem' => 'slug'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nome' => 'text',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'ordem' => 'ASC'
        );
    }

    public function adjustToDb($data) {
        unset($data['upload']);
        return parent::adjustToDb($data);
    }

    public function BuscarPorPromocao($promocao_id) {
        $sql = clone ($this->_basicSearch);
        $sql->where('promocao_id = ?', $promocao_id)
                ->order('ordem ASC');
        return $sql->query()->fetchAll();
    }

}
