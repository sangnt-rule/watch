<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/28/16
 * Time: 5:08 PM
 */
class Admin_View_Helper_ServiceUrl extends Zend_View_Helper_Abstract
{
    public function serviceUrl($id, $title, $config)
    {
        return sprintf(
            '%s/service/detail/?param=%d-%s',
            $config->env->front_end,
            $id,
            Application_Function_String::getFormatUrl($title)
        );
    }
}