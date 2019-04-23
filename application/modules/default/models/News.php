<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/26/16
 * Time: 2:16 PM
 */
class Model_News extends Application_Singleton
{
    /**
     * @var Model_Dao_News
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_News();
    }

    /**
     * Search newest by locale ID
     * @param int $localeId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchNewest($localeId)
    {
        $key = Application_Cache_Default::getInstance()->newest($localeId);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->searchNewest(3, $localeId);
            if ($data) {
                $result = $data->toArray();
            }
            Application_Cache::getInstance()->save($result, $key, null);
        }
        return $result;
    }

    /**
     * Search newest by locale ID
     * @param int $category
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchNewestByCategory($category)
    {
        $key = Application_Cache_Default::getInstance()->newestCategory($category);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->searchNewestByCategory(3, $category);
            if ($data) {
                $result = $data->toArray();
            }
            Application_Cache::getInstance()->save($result, $key, null);
        }
        return $result;
    }

    /**
     * Generate Url
     * @param int $id
     * @param string $title
     * @return string
     */
    public function generateUrl($id, $title)
    {
        $result = '';
        $config = Zend_Registry::get('config');
        $route = $config->resources->router->routes->news_detail->route;
        if ($route) {
            $route = Application_Function_Common::formatRouteConfig($route);
            $routeInfo = explode('/', $route);
            $routeInfo[count($routeInfo)-1] = sprintf(
                '%d-%s.html',
                $id,
                Application_Function_String::getFormatUrl($title)
            );
            $result = implode('/', $routeInfo);
        }
        return '/'. $result;
    }

    /**
     * Generate query for searching
     * @param int $localeId
     * @param int $categoryId
     * @param string $keyword
     * @return Zend_Db_Select
     */
    public function searchQuery($localeId, $categoryId, $keyword)
    {
        $localeId = intval($localeId);
        $categoryId = intval($categoryId);
        $keyword = trim($keyword);
        return $this->_dao->searchQuery($localeId, $categoryId, $keyword);
    }

    /**
     * Search newest by locale ID
     * @param int $id
     * @return array
     */
    public function getInfo($id)
    {
        $key = Application_Cache_Default::getInstance()->newsInfo($id);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->find($id);
            if ($data) {
                $result = $data->current()->toArray();
            }
            Application_Cache::getInstance()->save($result, $key, null);
        }
        return $result;
    }

    /**
     * Search suggestion
     * @param int $id
     * @param int $category
     * @return array
     */
    public function searchSuggestion($id, $category)
    {
        $id = intval($id);
        $category = intval($category);
        $data = $this->_dao->searchSuggestion($id, $category);
        return $data ? $data->toArray() : null;
    }

    /**
     * Search newest by locale ID
     * @param int $locale
     * @return array
     */
    public function searchSponsor($locale)
    {
        $locale = intval($locale);
        $key = Application_Cache_Default::getInstance()->newsSponsor($locale);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->searchSponsor($locale);
            if ($data) {
                $result = $data->toArray();
                Application_Cache::getInstance()->save($result, $key, null);
            }
        }
        return $result;
    }

    /**
     * Search sponsor by category
     * @param int $locale
     * @param int $categoryId
     * @return array
     */
    public function searchSponsorCategory($locale, $categoryId)
    {
        $result = array();
        $categoryId = intval($categoryId);
        $data = $this->searchSponsor($locale);
        if ($data) {
            foreach ($data as $item) {
                if ($item[DbTable_News::COL_FK_NEWS_CATEGORY] == $categoryId) {
                    array_push($result, $item);
                }
            }
        }
        return $result;
    }

    /**
     * Search sponsor data without category ID
     * @param int $locale
     * @param int $categoryExclude
     * @return array
     */
    public function searchSponsorExcludeCategory($locale, $categoryExclude)
    {
        $result = array();
        $categoryExclude = intval($categoryExclude);
        $data = $this->searchSponsor($locale);
        if ($data) {
            foreach ($data as $item) {
                if ($item[DbTable_News::COL_FK_NEWS_CATEGORY] != $categoryExclude) {
                    array_push($result, $item);
                }
            }
        }
        return $result;
    }


}