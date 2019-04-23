<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/4/16
 * Time: 2:15 PM
 */
class Model_Banner extends Application_Singleton
{
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Banner();
    }

    /**
     * Get all config of activation
     * @return array|false|mixed
     */
    public function getAll()
    {
        $key = Application_Cache_Default::getInstance()->banner();
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
     * Get banner of page
     * @param $originalId
     * @param $localeId
     * @return array
     */
    public function getByOriginalAndLocale($originalId, $localeId)
    {
        $data = $this->getAll();
        $originalId = intval($originalId);
        $localeId = intval($localeId);
        $result = array();
        foreach ($data as $item) {
            if ($item[DbTable_Banner::COL_BANNER_ORIGINAL] == $originalId && $item[DbTable_Banner::COL_FK_LOCALE] == $localeId) {
                $result = $item;
                break;
            }
        }
        return $result;
    }
}