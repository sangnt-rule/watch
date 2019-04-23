<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/10/16
 * Time: 10:23 PM
 */
class Admin_Model_Dao_Slider extends DbTable_Slider
{
    /**
     * Generate search query
     * @param int $locale
     * @param string $title
     * @param int $activeId
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($locale, $title, $activeId)
    {
        $select = $this->select()
            ->from(
                DbTable_Slider::_tableName,
                array(
                    DbTable_Slider::COL_SLIDER_ID,
                    DbTable_Slider::COL_SLIDER_TITLE,
                    DbTable_Slider::COL_SLIDER_IMAGE,
                    DbTable_Slider::COL_SLIDER_CONTENT,
                    DbTable_Slider::COL_SLIDER_URL,
                    DbTable_Slider::COL_SLIDER_PRIORITY,
                    DbTable_Slider::COL_FK_CONFIG_ACTIVE,
                    DbTable_Slider::COL_FK_LOCALE,
                    DbTable_Slider::COL_SLIDER_ORIGINAL,
                )
            )
        ;
        if ($activeId > -1) {
            $select->where(DbTable_Slider::COL_FK_CONFIG_ACTIVE . '=?', $activeId);
        }
        if ($locale) {
            $select->where(DbTable_Slider::COL_FK_LOCALE . '=?', $locale);
        }
        if ($title) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_Slider::COL_SLIDER_TITLE . ')'),
                    $this->getAdapter()->quote('%' . strtolower($title) . '%')
                )
            );
        }
        $select->order(DbTable_Slider::COL_SLIDER_ID . ' DESC');
        return $select;
    }

    /**
     * Get by original ID
     * @param int $originalId
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getByOriginalId($originalId)
    {
        $select = $this->select()->where(DbTable_Slider::COL_SLIDER_ORIGINAL . '=?', $originalId);
        return $this->fetchAll($select);
    }
}