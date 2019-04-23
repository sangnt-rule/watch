<?php
/**
 * Created by PhpStorm.
 * User: tranquockiet
 * Date: 23/01/2016
 * Time: 11:46 SA
 */
class Controller_Helper_ListArrayDistrictSaiGon extends Zend_Controller_Action_Helper_Abstract
{
    public function direct()
    {
        return Application_Function_DistrictSaiGon::getAllDistrict();
    }
}