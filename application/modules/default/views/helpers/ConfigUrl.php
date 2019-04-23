<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/21/16
 * Time: 4:42 PM
 */
class View_Helper_ConfigUrl extends Zend_View_Helper_Abstract
{
    public function configUrl($config, $routeName, $subDomain='default')
    {
        $result = '/' . Application_Function_Common::formatRouteConfig($config->resources->router->routes->$routeName->route);
        if ($subDomain) {
            $host = Application_Function_Common::currentUrl();
            $result = $host . $result;
        }
        return $result;
    }
}