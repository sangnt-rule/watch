<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/16/16
 * Time: 1:21 PM
 */
class View_Filter_Db_Recruitment_ExpiredAt extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return date('Y-m-d', strtotime($value));
    }
}