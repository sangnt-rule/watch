<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_ProjectCategoryUrl extends Zend_View_Helper_Abstract
{
    public function projectCategoryUrl($id, $name)
    {
        return Model_ProjectCategory::getInstance()->generateUrl($id, $name);
    }
}