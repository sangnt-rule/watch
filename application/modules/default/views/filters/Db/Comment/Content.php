<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/16/16
 * Time: 2:39 PM
 */
class View_Filter_Db_Comment_Content extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        return $value;
    }
}