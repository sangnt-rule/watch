<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_NewsUrl extends Zend_View_Helper_Abstract
{
    public function newsUrl($id, $name)
    {
        return Model_News::getInstance()->generateUrl($id, $name);
    }
}