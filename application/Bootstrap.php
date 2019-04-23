<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRegistry()
    {
        $this->bootstrap('multiDb');
        $multiDb = $this->getPluginResource('multiDb');
        Zend_Registry::set('db_master', $multiDb->getDb('master'));
        Zend_Registry::set('db_slave', $multiDb->getDb('slave'));
    }

    protected function _initCache()
    {
        $config = Zend_Registry::get('config');
        $backend = strtolower($config->cache->backend->type);
        $cache = Zend_Cache::factory(
            'Core',
            ucfirst($backend),
            $config->cache->frontend->options->toArray(),
            $config->cache->backend->options->$backend->toArray()
        );
        Zend_Registry::set('cache', $cache);
    }

    protected function _initErrorHandling()
    {
        $config = Zend_Registry::get('config');
        $display_errors = $config->phpSettings->display_errors;
        if ($display_errors != 1) {
            $options = array(
                'module'     => 'default',
                'controller' => 'site-content',
                'action'     => 'error404'
            );
        } else {
            $options = array(
                'module'     => 'error',
                'controller' => 'error',
                'action'     => 'error'
            );
        }

        $frontController = $this->bootstrap("frontController")->frontController;
        $frontController->registerPlugin(
            new Zend_Controller_Plugin_ErrorHandler($options)
        );
    }

    protected function _initAutoLoad()
    {
        $frontController = $this->bootstrap("frontController")->frontController;
        $modules = $frontController->getControllerDirectory();
        $default = $frontController->getDefaultModule();

        $loader = Zend_Loader_Autoloader::getInstance();
        #$routers = $frontController->getRouter();
        foreach (array_keys($modules) as $module) {
            $namespace = $module === $default ? '' : ucwords($module);
            #Auto load
            $loader->pushAutoloader(
                new Zend_Application_Module_Autoloader(
                    array(
                        'namespace' => $namespace,
                        'basePath'  => $frontController->getModuleDirectory($module)
                    )
                )
            );
            #Auto load

            #Helper
            Zend_Controller_Action_HelperBroker::addPath(
                $frontController->getModuleDirectory($module) . '/controllers/helpers',
                sprintf(
                    '%sController_Helper',
                    $module==$default ? '' : $namespace . '_'
                )
            );
            #Helper
        }
        return $loader;
    }

    protected function _initDefinition()
    {
        define('HOST_UPLOAD', '/upload');
        define('PATH_UPLOAD', APPLICATION_PATH . '/../public/upload');
    }

}