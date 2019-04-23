<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/27/16
 * Time: 6:13 PM
 */
class View_Filter_Db_Booking_Phone extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        return strtolower($value);
    }
}