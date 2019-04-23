<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_AboutUsCategoryUrl extends Zend_View_Helper_Abstract
{
    public function aboutUsCategoryUrl($id, $name)
    {
        return Model_AboutUsCategory::getInstance()->generateUrl($id, $name);
    }
}