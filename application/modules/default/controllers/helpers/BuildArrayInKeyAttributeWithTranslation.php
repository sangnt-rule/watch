<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 2:52 PM
 */
class Controller_Helper_BuildArrayInKeyAttributeWithTranslation extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($array, $keyName, $attributeName, $translate)
    {
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                $key = isset($item[$keyName]) ? $item[$keyName] : null ;
                $attribute = isset($item[$attributeName]) ? $item[$attributeName] : null ;
                if ( !is_null($key) && !is_null($attribute) ) {
                    $result[$key] = $translate->_($attribute);
                }
            }
        }
        return $result;
    }
}