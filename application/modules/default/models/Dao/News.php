<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/26/16
 * Time: 2:15 PM
 */
class Model_Dao_News extends DbTable_News
{
    /**
     * Search newest by locale ID
     * @param int $limit
     * @param int $localeId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchNewest($limit, $localeId)
    {
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_IMAGE,
                    DbTable_News::COL_NEWS_SUB_CONTENT,
                    DbTable_News::COL_NEWS_CREATED_AT,
                )
            )
            ->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_News::COL_FK_LOCALE . '=?', $localeId)
            ->order(DbTable_News::COL_NEWS_ID .' desc')
            ->limit($limit)
        ;
        return $this->fetchAll($select);
    }

    /**
     * Search newest by locale ID
     * @param int $limit
     * @param int $categoryId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchNewestByCategory($limit, $categoryId)
    {
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_IMAGE,
                    DbTable_News::COL_NEWS_SUB_CONTENT,
                )
            )
            ->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_News::COL_FK_NEWS_CATEGORY . '=?', $categoryId)
            ->order(DbTable_News::COL_NEWS_ID .' desc')
            ->limit($limit)
        ;
        return $this->fetchAll($select);
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
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_IMAGE,
                    DbTable_News::COL_NEWS_SUB_CONTENT,
                    DbTable_News::COL_NEWS_CREATED_AT,
                )
            )
            ->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_News::COL_FK_LOCALE . '=?', $localeId)
        ;
        if ($categoryId) {
            $select->where(DbTable_News::COL_FK_NEWS_CATEGORY . '=?', $categoryId);
        }
        if ($keyword) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_News::COL_NEWS_TITLE . ')'),
                    $this->getAdapter()->quote('%' . strtolower($keyword) . '%')
                )
            );
        }
        $select->order(DbTable_News::COL_NEWS_ID . ' desc');
        return $select;
    }

    /**
     * Search suggestion
     * @param int $id
     * @param int $category
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchSuggestion($id, $category)
    {
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_CREATED_AT,
                )
            )
            ->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_News::COL_FK_NEWS_CATEGORY . '=?', $category)
            ->where(DbTable_News::COL_NEWS_ID . '<>?', $id)
            ->limit(3)
        ;
        $select->order(DbTable_News::COL_NEWS_ID . ' desc');
        return $this->fetchAll($select);
    }

    /**
     * Search sponsor
     * @param int $locale
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchSponsor($locale)
    {
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_IMAGE,
                    DbTable_News::COL_NEWS_SUB_CONTENT,
                    DbTable_News::COL_FK_NEWS_CATEGORY,
                    DbTable_News::COL_NEWS_CREATED_AT,
                )
            )
            ->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->where(DbTable_News::COL_NEWS_SPONSOR . '=1')
            ->where(DbTable_News::COL_FK_LOCALE . '=?', $locale)
        ;
        return $this->fetchAll($select);
    }
}