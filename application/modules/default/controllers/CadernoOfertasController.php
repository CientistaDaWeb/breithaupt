<?php

class Default_CadernoOfertasController extends Default_Controller_Action {

    public function indexAction() {

        $id = $this->_getParam('id');
        if (empty($id)):
            $JornalModel = new Jornal_Model();
            $jornal = $JornalModel->getJornal();
        else:
            $jornal['id'] = $id;
            $this->view->preview = true;
        endif;
        if (!empty($jornal)):
            $JornalPaginasModel = new JornalPaginas_Model();
            $paginas = $JornalPaginasModel->BuscarPorJornal($jornal['id']);
            $this->view->paginas = $paginas;
        endif;
    }

}
