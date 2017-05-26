<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoLoader() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('WS');
        $autoloader->registerNamespace('Phpmailer');
        $autoloader->registerNamespace('Erp');
        $autoloader->registerNamespace('Cliente');
        $autoloader->registerNamespace('ZFDebug');
        $autoloader->registerNamespace('ZendX');
        $autoloader->registerNamespace('Storage');
        $autoloader->setFallbackAutoloader(true);
        return $autoloader;
    }

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initConfigs() {
        $application = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('application', $application);
    }

    protected function _initRedirect() {
        $configs = Zend_Registry::get('application');

        if ($_SERVER['SERVER_ADDR'] == $configs->cliente->ip) :
            if ($_SERVER['HTTP_HOST'] != 'www.' . $configs->cliente->dominio) :
                $url = $_SERVER['REQUEST_URI'];
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: http://www.' . $configs->cliente->dominio . $url);
                define('UPLOAD_PATH', APPLICATION_PATH . '/../www/uploads/');
            endif;
        endif;
    }

    protected function _initTranslate() {
        $translator = new Zend_Translate(array('adapter' => 'array', 'content' => '../library/Translate/Validate/', 'locale' => 'pt_BR', 'scan' => Zend_Translate::LOCALE_DIRECTORY));
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

    protected function _initLocale() {
        $locale = new Zend_Locale();
        $locale->setLocale('pt_BR');
    }

    protected function _initCache() {
        $frontendOptions = array('lifetime' => null, 'automatic_serialization' => true);
        $backendOptions = array();
        $coreCache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Db_Table_Abstract::setDefaultMetadataCache($coreCache);
        Zend_Registry::set('cache', $coreCache);
    }

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) :
            $bootstrap = $this;
        endif;
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        /* Plugin do Layout */
        $front->registerPlugin(new WS_Plugins_Layout());

        /* Plugin de erro */
        $front->registerPlugin(new WS_ErrorControllerSelector());

        /* Plugin do ZFDebug */
        $application = Zend_Registry::get('application');
        if ($application->zfdebug->enabled):
            $options = array(
                'plugins' => array('Variables',
                    'File' => array('base_path' => APPLICATION_PATH . '/../tmp'),
                    'Memory',
                    'Time',
                    'Registry',
                    'Exception')
            );

            if ($this->hasPluginResource('db')) :
                $this->bootstrap('db');
                $db = $this->getPluginResource('db')->getDbAdapter();
                $options['plugins']['Database']['adapter'] = $db;
            endif;

            if ($this->hasPluginResource('cache')) :
                $this->bootstrap('cache');
                $cache = $this - getPluginResource('cache')->getDbAdapter();
                $options['plugins']['Cache']['backend'] = $cache->getBackend();
            endif;

            $front->registerPlugin(new ZFDebug_Controller_Plugin_Debug($options));
        endif;
    }

    protected function _initRotes() {
        $modulo = 'default';
        $this->controller = Zend_Controller_Front::getInstance();
        $this->router = $this->controller->getRouter();
        $this->router->addRoute('default', new Zend_Controller_Router_Route('/:controller/:action', array(
            'controller' => 'index',
            'action' => 'index',
            'module' => $modulo,
        )));

        $this->router->addRoute('noticia', new Zend_Controller_Router_Route('/noticia/:slug', array(
            'controller' => 'noticias',
            'action' => 'noticia',
            'module' => $modulo,
            'slug' => '',
        )));
        $this->router->addRoute('trabalhe-conosco', new Zend_Controller_Router_Route('/trabalhe-conosco/:slug', array(
            'controller' => 'trabalhe-conosco',
            'action' => 'index',
            'module' => $modulo,
            'slug' => '',
        )));
        $this->router->addRoute('pegacidades', new Zend_Controller_Router_Route('/pegacidades/:uf', array(
            'controller' => 'trabalhe-conosco',
            'action' => 'pegacidades',
            'module' => $modulo,
            'uf' => '',
        )));
        $this->router->addRoute('noticias', new Zend_Controller_Router_Route('/noticias/:pagina', array(
            'controller' => 'noticias',
            'action' => 'index',
            'module' => $modulo,
            'pagina' => 1,
        )));
        $this->router->addRoute('busca-historico', new Zend_Controller_Router_Route('/empresa/busca-historico/:year', array(
            'controller' => 'empresa',
            'action' => 'buscahistorico',
            'module' => $modulo,
            'year' => '',
        )));
        $this->router->addRoute('busca-loja', new Zend_Controller_Router_Route('/busca-loja/:id', array(
            'controller' => 'nossas-lojas',
            'action' => 'busca',
            'module' => $modulo,
            'id' => '',
        )));
        $this->router->addRoute('busca-localizacao', new Zend_Controller_Router_Route('/busca-localizacao/:id', array(
            'controller' => 'nossas-lojas',
            'action' => 'localizacao',
            'module' => $modulo,
            'id' => '',
        )));
        $this->router->addRoute('caderno-ofertas', new Zend_Controller_Router_Route('/caderno-ofertas/:id', array(
            'controller' => 'caderno-ofertas',
            'action' => 'index',
            'module' => $modulo,
            'id' => '',
        )));
        $this->router->addRoute('lisca-cursos', new Zend_Controller_Router_Route('/clube-do-profissional/listacurso/:slug', array(
            'controller' => 'clube-do-profissional',
            'action' => 'listacurso',
            'module' => $modulo,
            'slug' => '',
        )));
        $this->router->addRoute('curso', new Zend_Controller_Router_Route('/clube-do-profissional/curso/:slug', array(
            'controller' => 'clube-do-profissional',
            'action' => 'curso',
            'module' => $modulo,
            'slug' => '',
        )));
        $this->router->addRoute('promocoes', new Zend_Controller_Router_Route('/promocoes/:id', array(
            'controller' => 'promocoes',
            'action' => 'index',
            'module' => $modulo,
            'id' => '',
        )));
        $this->router->addRoute('fimdeano', new Zend_Controller_Router_Route('/horarios-fim-de-ano', array(
            'controller' => 'index',
            'action' => 'horariosfimdeano',
            'module' => $modulo,
            'id' => '',
        )));
    }

}