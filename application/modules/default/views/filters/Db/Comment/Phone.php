<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/16/16
 * Time: 2:38 PM
 */
class View_Filter_Db_Comment_Phone extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        return strtolower($value);
    }
}