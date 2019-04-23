<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_IntroCategoryUrl extends Zend_View_Helper_Abstract
{
    public function introCategoryUrl($id, $name)
    {
        return Model_IntroCategory::getInstance()->generateUrl($id, $name);
    }
}