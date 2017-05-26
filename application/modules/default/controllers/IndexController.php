<?php

class Default_IndexController extends Default_Controller_Action {

    public function indexAction() {
        $this->view->slideshow = true;
        $NoticiasModel = new Noticias_Model();
        $this->view->noticias_destaque = $NoticiasModel->destaques();

        $JornalModel = new Jornal_Model();
        $jornal = $JornalModel->getJornal();
        $this->view->jornal = $jornal;

        $VideosModel = new Videos_Model();
        $video = $VideosModel->getVideo();
        $this->view->video = $video;

        $BannersFlutuantesModel = new BannersFlutuantes_Model();
        $banner = $BannersFlutuantesModel->getBanner();
        $this->view->banner = $banner;
    }

    function horariosfimdeanoAction(){

    }

}
