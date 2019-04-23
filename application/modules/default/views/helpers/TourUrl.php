<?php

class View_Helper_TourUrl extends Zend_View_Helper_Abstract
{
    public function TourUrl($id, $name)
    {
        return Model_Tour::getInstance()->generateUrl($id, $name);
    }
}