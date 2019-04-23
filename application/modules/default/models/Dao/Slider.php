<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/24/16
 * Time: 11:47 PM
 */
class Model_Dao_Slider extends DbTable_Slider
{
    /**
     * Get all news category
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()
            ->from(
                DbTable_Slider::_tableName,
                array(
                    DbTable_Slider::COL_SLIDER_TITLE,
                    DbTable_Slider::COL_SLIDER_IMAGE,
                    DbTable_Slider::COL_SLIDER_CONTENT,
                    DbTable_Slider::COL_SLIDER_URL,
                    DbTable_Slider::COL_FK_LOCALE
                )
            )
            ->where(DbTable_Slider::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Slider::COL_SLIDER_PRIORITY . ' desc')
        ;
        return $this->fetchAll($select);
    }
}