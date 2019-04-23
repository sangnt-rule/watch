<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/13/16
 * Time: 3:55 PM
 */
class Model_Dao_IntroCategory extends DbTable_Intro_Category
{
    /**
     * Get all news category
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAll()
    {
        $select = $this->select()
            ->from(
                DbTable_Intro_Category::_tableName,
                array(
                    DbTable_Intro_Category::COL_INTRO_CATEGORY_ID,
                    DbTable_Intro_Category::COL_INTRO_CATEGORY_NAME,
                    DbTable_Intro_Category::COL_FK_LOCALE
                )
            )
            ->where(DbTable_Intro_Category::COL_FK_CONFIG_ACTIVE . '=?', Application_Constant_Db_Config_Active::ACTIVE)
            ->order(DbTable_Intro_Category::COL_INTRO_CATEGORY_PRIORITY . ' desc')
        ;
        return $this->fetchAll($select);
    }
}
