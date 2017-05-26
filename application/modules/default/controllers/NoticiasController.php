<?php

class Default_NoticiasController extends Default_Controller_Action {

    public function init() {
        $this->model = new Noticias_Model();
        parent::init();
        $destaques = $this->model->destaques();
        $this->view->destaques = $destaques;
    }

    public function indexAction() {
        $pagina = $this->_getParam('pagina');
        $noticias = $this->model->paginada($pagina);
        $this->view->noticias = $noticias;
        $parametros['pagina'] = $pagina;
        $parametros['route'] = 'noticias';
        $this->view->parametros = $parametros;
    }

    public function noticiaAction() {
        $slug = $this->_getParam('slug');
        $this->view->noticia = $this->model->adjustToView($this->model->getBySlug($slug));
    }

}
