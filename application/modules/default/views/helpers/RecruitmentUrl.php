<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/26/16
 * Time: 3:53 PM
 */
class View_Helper_RecruitmentUrl extends Zend_View_Helper_Abstract
{
    public function recruitmentUrl($id, $name)
    {
        return Model_Recruitment::getInstance()->generateUrl($id, $name);
    }
}