<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 11:17 AM
 */
class Admin_View_Helper_HorseTypeNameById extends Zend_View_Helper_Abstract
{
    public function horseTypeNameById($id)
    {
        return Admin_Model_HorseType::getInstance()->getNameById($id);
    }
}