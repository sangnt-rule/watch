<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:23 PM
 */
class Admin_Model_Dao_News extends DbTable_News
{
    /**
     * Generate search query
     * @param int $locale
     * @param int $categoryId
     * @param string $title
     * @param int $activeId
     * @param int $sponsor
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $categoryId, $title, $activeId, $sponsor)
    {
        $select = $this->select()
            ->from(
                DbTable_News::_tableName,
                array(
                    DbTable_News::COL_NEWS_ID,
                    DbTable_News::COL_NEWS_TITLE,
                    DbTable_News::COL_NEWS_IMAGE,
                    DbTable_News::COL_NEWS_SUB_CONTENT,
                    DbTable_News::COL_NEWS_SPONSOR,
                    DbTable_News::COL_NEWS_CREATED_AT,
                    DbTable_News::COL_NEWS_UPDATED_AT,
                    DbTable_News::COL_FK_CONFIG_ACTIVE,
                    DbTable_News::COL_FK_LOCALE,
                    DbTable_News::COL_FK_NEWS_CATEGORY,
                    DbTable_News::COL_NEWS_ORIGINAL,
                )
            )
        ;
        if ($activeId > -1) {
            $select->where(DbTable_News::COL_FK_CONFIG_ACTIVE . '=?', $activeId);
        }
        if ($sponsor > -1) {
            $select->where(DbTable_News::COL_NEWS_SPONSOR . '=?', $sponsor);
        }
        if ($locale) {
            $select->where(DbTable_News::COL_FK_LOCALE . '=?', $locale);
        }
        if ($categoryId) {
            $select->where(DbTable_News::COL_FK_NEWS_CATEGORY . '=?', $categoryId);
        }
        if ($title) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_News::COL_NEWS_TITLE . ')'),
                    $this->getAdapter()->quote('%' . strtolower($title) . '%')
                )
            );
        }
        $select->order(DbTable_News::COL_NEWS_ID . ' DESC');
        return $select;
    }

    /**
     * Get by original ID
     * @param int $originalId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByOriginalId($originalId)
    {
        $select = $this->select()->where(DbTable_News::COL_NEWS_ORIGINAL . '=?', $originalId);
        return $this->fetchAll($select);
    }
}