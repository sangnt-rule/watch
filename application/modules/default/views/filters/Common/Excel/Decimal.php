<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/29/16
 * Time: 8:46 PM
 */
class View_Filter_Common_Excel_Decimal extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = trim($value);
        $value = str_replace(',', '.', $value);
        return $value;
    }
}