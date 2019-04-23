<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/24/16
 * Time: 11:48 PM
 */
class Model_Slider extends Application_Singleton
{
    /**
     * @var Model_Dao_Slider
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Slider();
    }

    /**
     * Get all config of activation
     * @return array|false|mixed
     */
    public function getAll()
    {
        $key = Application_Cache_Default::getInstance()->slider();
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getAll();
            if ($data) {
                $result = $data->toArray();
            }
            Application_Cache::getInstance()->save($result, $key, null);
        }
        return $result;
    }

    /**
     * Search by locale ID
     * @param int $localeId
     * @return array
     */
    public function searchByLocaleId($localeId)
    {
        $result = array();
        $data = $this->getAll();
        foreach ($data as $item) {
            if ($item[DbTable_Slider::COL_FK_LOCALE] == $localeId) {
                array_push($result, $item);
            }
        }
        return $result;
    }
}