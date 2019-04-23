<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/28/16
 * Time: 5:08 PM
 */
class Admin_View_Helper_ScheduleUrl extends Zend_View_Helper_Abstract
{
    public function scheduleUrl($id, $title, $config)
    {
        return sprintf(
            '%s/schedule/detail/?param=%d-%s',
            $config->env->front_end,
            $id,
            Application_Function_String::getFormatUrl($title)
        );
    }
}