<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/11/16
 * Time: 11:34 AM
 */
class View_Helper_ConfigActiveNameById extends Zend_View_Helper_Abstract
{
    public function configActiveNameById($id)
    {
        return Model_ConfigActive::getInstance()->getNameById($id);
    }
}