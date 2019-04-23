<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:23 PM
 */
class Admin_Model_Dao_Banner extends DbTable_Banner
{
    /**
     * Generate search query
     * @param int $locale
     * @param int $activeId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $activeId)
    {
        $select = $this->select()
            ->from(
                DbTable_Banner::_tableName,
                array(
                    DbTable_Banner::COL_BANNER_ID,
                    DbTable_Banner::COL_BANNER_NOTE,
                    DbTable_Banner::COL_BANNER_IMAGE,
                    DbTable_Banner::COL_FK_CONFIG_ACTIVE,
                    DbTable_Banner::COL_FK_LOCALE,
                    DbTable_Banner::COL_BANNER_ORIGINAL,
                    DbTable_Banner::COL_BANNER_META_TITLE,
                    DbTable_Banner::COL_BANNER_META_DESCRIPTION,
                    DbTable_Banner::COL_BANNER_META_KEYWORD,
                )
            )
        ;
        if ($activeId > -1) {
            $select->where(DbTable_Banner::COL_FK_CONFIG_ACTIVE . '=?', $activeId);
        }
        if ($locale) {
            $select->where(DbTable_Banner::COL_FK_LOCALE . '=?', $locale);
        }
        return $select;
    }

    /**
     * Get by original ID
     * @param int $originalId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByOriginalId($originalId)
    {
        $select = $this->select()->where(DbTable_Banner::COL_BANNER_ORIGINAL . '=?', $originalId);
        return $this->fetchAll($select);
    }
}