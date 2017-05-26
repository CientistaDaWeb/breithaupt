<?php

class Zend_View_Helper_ClubeDoProfissionalMenu extends Zend_View_Helper_Navigation {

    public function ClubeDoProfissionalMenu() {
        // Clube do Profissional
        $subpages = array();
        $subpages[] = array(
            'title' => 'Cadastre-se',
            'label' => 'Cadastre-se',
            'controller' => 'clube-do-profissional',
            'action' => 'cadastre-se'
        );
        $subpages[] = array(
            'title' => 'Cursos',
            'label' => 'Cursos',
            'controller' => 'clube-do-profissional',
            'action' => 'cursos'
        );
        $subpages[] = array(
            'title' => 'Notícias',
            'label' => 'Notícias',
            'controller' => 'clube-do-profissional',
            'action' => 'noticias'
        );
        $subpages[] = array(
            'title' => 'Profisisonais',
            'label' => 'Profissionais',
            'controller' => 'clube-do-profissional',
            'action' => 'profissionais'
        );
        $page[] = array(
            'title' => 'Clube do Profissional',
            'label' => 'Clube do Profissional',
            'controller' => 'clube-do-profissional',
            'action' => 'index',
            'pages' => $subpages
        );


        $container = new Zend_Navigation($page);
        $this->setContainer($container);

        return $this;
    }

}

