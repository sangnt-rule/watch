<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/28/16
 * Time: 5:08 PM
 */
class Admin_View_Helper_ClubUrl extends Zend_View_Helper_Abstract
{
    public function clubUrl($id, $title, $config)
    {
        return sprintf(
            '%s/club/detail/?param=%d-%s',
            $config->env->front_end,
            $id,
            Application_Function_String::getFormatUrl($title)
        );
    }
}