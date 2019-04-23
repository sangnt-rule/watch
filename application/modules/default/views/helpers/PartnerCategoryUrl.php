<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_PartnerCategoryUrl extends Zend_View_Helper_Abstract
{
    public function partnerCategoryUrl($id, $name)
    {
        return Model_PartnerCategory::getInstance()->generateUrl($id, $name);
    }
}