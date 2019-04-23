<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/26/15
 * Time: 9:43 AM
 */
class Application_Function_Array
{
    static public function group($array, $qty)
    {
        $totalPage = ceil(count($array)/$qty);
        $result = array();
        for ($i=1; $i<=$totalPage; $i++) {
            $result[] = array_slice($array, ($i-1)*$qty, $qty);
        }
        return $result;
    }

    /**
     * Build new array by key
     * @param array $array
     * @param string $keyName
     * @return array
     */
    static public function buildArrayByKey($array, $keyName)
    {
        $keyName = trim($keyName);
        $result = array();
        if ($array) {
            foreach ($array as $item) {
                $value = isset($item[$keyName]) ? $item[$keyName] : null ;
                if ($value && !in_array($value, $result) ) {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Check if all elements are null
     * @param array $row
     * @return bool
     */
    static function isValidatedRow($row)
    {
        $result = false;
        if ($row) {
            foreach ($row as $value) {
                if (!empty($value) && $value) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }
}