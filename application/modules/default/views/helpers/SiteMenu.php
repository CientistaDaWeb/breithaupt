<?php

class Zend_View_Helper_SiteMenu extends Zend_View_Helper_Navigation {

    public function SiteMenu() {
        // Home
        $page[] = array(
            'controller' => 'index',
            'route' => 'default',
            'label' => 'Home',
            'title' => 'Home',
        );

        // O Breithaupt
        $subpages = null;
        $subpages[] = array(
            'title' => 'Apresentação',
            'label' => 'Apresentação',
            'controller' => 'empresa',
            'action' => 'apresentacao',
            'route' => 'default',
        );
        /*
         $subpages[] = array(
            'title' => 'Histórico',
            'label' => 'Histórico',
            'controller' => 'empresa',
            'action' => 'historico',
            'route' => 'default',
        );
          $subpages[] = array(
          'title' => 'Missão, Visão e Valores',
          'label' => 'Missão, Visão e Valores',
          'controller' => 'empresa',
          'action' => 'missao-visao-e-valores',
          'route' => 'default',
          );
         * */
          $subpages[] = array(
            'title' => 'Breithaupt Social',
            'label' => 'Breithaupt Social',
            'controller' => 'breithaupt-social',
            'route' => 'default',
        );
        $subpages[] = array(
            'title' => 'Grupo Breithaupt',
            'label' => 'Grupo Breithaupt',
            'controller' => 'grupo-breithaupt',
            'route' => 'default',
        );
        $subpages[] = array(
            'title' => 'Notícias',
            'label' => 'Notícias',
            'controller' => 'noticias',
            'route' => 'default',
        );
        $subpages[] = array(
            'title' => 'Cursos',
            'label' => 'Cursos',
            'controller' => 'clube-do-profissional',
            'action' => 'cursos',
            'route' => 'default',
        );
        $page[] = array(
            'title' => 'O Breithaupt',
            'label' => 'O Breithaupt',
            'controller' => 'empresa',
            'action' => 'apresentacao',
            'route' => 'default',
            'pages' => $subpages
        );

        // Lojas e Home Centers
        $subpages = null;
        $subpages[] = array(
            'title' => 'Nossas Lojas',
            'label' => 'Nossas Lojas',
            'controller' => 'nossas-lojas',
            'route' => 'default',
        );
        $subpages[] = array(
            'title' => 'Serviços',
            'label' => 'Serviços',
            'controller' => 'servicos',
            'route' => 'default',
        );
        /*
          $subpages[] = array(
          'title' => 'Faça Você Mesmo',
          'label' => 'Faça Você Mesmo',
          'controller' => 'faca-voce-mesmo',
          'route' => 'default',
          );
          $subpages[] = array(
          'title' => 'Dicas Breithaupt',
          'label' => 'Dicas Breithaupt',
          'controller' => 'dicas-breithaupt',
          'route' => 'default',
          );
         */
        $subpages[] = array(
            'title' => 'Formas de Pagamento',
            'label' => 'Formas de Pagamento',
            'controller' => 'formas-pagamento',
            'route' => 'default',
        );
        /*
          $subpages[] = array(
          'title' => 'Clube do Profissional',
          'label' => 'Clube do Profissional',
          'controller' => 'clube-do-profissional',
          'route' => 'default',
          );
         */
        $page[] = array(
            'title' => 'Lojas e Home Centers',
            'label' => 'Lojas e Home Centers',
            'controller' => 'nossas-lojas',
            'route' => 'default',
            'pages' => $subpages,
        );
        // Produtos
        /*
          $page[] = array(
          'title' => 'Produtos',
          'label' => 'Produtos',
          'uri' => 'http://breithaupt.com.br/loja/',
          );
         */

        // Jornal de Ofertas
        $subpages = array();

        $PromocoesModel = new Promocoes_Model();
        $promocao = $PromocoesModel->getPromocao();
        if (!empty($promocao)):
            $subpages[] = array(
                'title' => 'Promoções',
                'label' => 'Promoções',
                'controller' => 'promocoes',
                'action' => 'index',
                'route' => 'promocoes',
            );
        endif;

        $page[] = array(
            'title' => 'Caderno de Ofertas',
            'label' => 'Caderno de Ofertas',
            'controller' => 'caderno-ofertas',
            'route' => 'caderno-ofertas',
            'pages' => $subpages,
        );
        // Trabalhe Conosco
        $page[] = array(
            'title' => 'Trabalhe Conosco',
            'label' => 'Trabalhe Conosco',
            'controller' => 'trabalhe-conosco',
            'route' => 'default',
        );
        //Central do Cliente
        $page[] = array(
            'title' => 'Central do Cliente',
            'label' => 'Central do Cliente',
            'uri' => 'http://vendas.breithaupt.com.br/interno/PortalCliente.aspx',
        );
        // Fale Conosco
        $page[] = array(
            'controller' => 'fale-conosco',
            'route' => 'default',
            'label' => 'Fale Conosco',
            'title' => 'Fale Conosco',
            'route' => 'default',
        );

        // Clube do Profissional
        /*
          $subpages = null;
          $subpages[] = array(
          'title' => 'Cadastre-se',
          'label' => 'Cadastre-se',
          'controller' => 'clube-do-profissional',
          'action' => 'cadastre-se',
          'route' => 'default',
          );

          $subpages[] = array(
          'title' => 'Notícias',
          'label' => 'Notícias',
          'controller' => 'clube-do-profissional',
          'action' => 'noticias',
          'route' => 'default',
          );
          $subpages[] = array(
          'title' => 'Profisisonais',
          'label' => 'Profissionais',
          'controller' => 'clube-do-profissional',
          'action' => 'profissionais',
          'route' => 'default',
          );
          $page[] = array(
          'title' => 'Clube do Profissional',
          'label' => 'Clube do Profissional',
          'controller' => 'clube-do-profissional',
          'action' => 'index',
          'pages' => $subpages,
          'visible' => false,
          'route' => 'default',
          );
         */

        $container = new Zend_Navigation($page);
        $this->setContainer($container);

        return $this;
    }

}
