<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/6/16
 * Time: 3:21 PM
 */
class View_Filter_Common_Email extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return strtolower(trim($value));
    }
}