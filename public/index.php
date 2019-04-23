<?php
date_default_timezone_set('Asia/Saigon');
define('SYS_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', SYS_PATH . '/application');
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV'): 'production'));
define('PC_MODE', isset($_COOKIE['PC_MODE']) ? $_COOKIE['PC_MODE'] : 0);

$hostInfo = explode('.', $_SERVER['HTTP_HOST']);
$moduleName = 'default';

$subDomain = current($hostInfo);
if (strstr($subDomain, 'cms')) {
    $moduleName = 'admin';
} elseif (strstr($subDomain, 'ws')) {
    $moduleName = 'ws';
}
define('MODULE_NAME', $moduleName);
unset($hostInfo);
unset($moduleName);

set_include_path(implode(PATH_SEPARATOR, array(
    SYS_PATH . '/library',
    APPLICATION_PATH . '/libs',
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV, true);
$filename = APPLICATION_PATH . '/configs/' . APPLICATION_ENV . '.ini';
if (file_exists($filename)) {
    $config->merge(new Zend_Config_Ini($filename));
}
$filename = APPLICATION_PATH . '/modules/'. MODULE_NAME .'/configs/' . 'route.ini';
if (file_exists($filename)) {
    $config->merge(new Zend_Config_Ini($filename));
}
unset($filename);

Zend_Registry::set('config', $config);
$application = new Zend_Application(APPLICATION_ENV, $config);
$application->bootstrap()->run();