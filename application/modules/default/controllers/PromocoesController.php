<?php

class Default_PromocoesController extends Default_Controller_Action {

    public function indexAction() {

        $id = $this->_getParam('id');
        if (empty($id)):
            $PromocoesModel = new Promocoes_Model();
            $promocao = $PromocoesModel->getPromocao();
        else:
            $promocao['id'] = $id;
            $this->view->preview = true;
        endif;
        if (!empty($promocao)):
            $PromocoesPaginasModel = new PromocoesPaginas_Model();
            $paginas = $PromocoesPaginasModel->BuscarPorPromocao($promocao['id']);
            $this->view->paginas = $paginas;
        endif;
    }

}
