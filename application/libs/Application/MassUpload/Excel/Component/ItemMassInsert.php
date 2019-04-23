<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/16
 * Time: 3:28 PM
 */
class Application_MassUpload_Excel_Component_ItemMassInsert extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_partnerId;

    /**
     * @var int
     */
    private $_locationId;

    /**
     * @var array
     */
    static $idProduct = array();

    /**
     * Set partner ID
     * @param int $value
     */
    public function setPartnerId($value)
    {
        $this->_partnerId = $value;
    }

    /**
     * Get partner ID
     * @return int
     */
    public function getPartnerId()
    {
        return $this->_partnerId;
    }

    /**
     * Set location ID
     * @param int $value
     */
    public function setLocationId($value)
    {
        $this->_locationId = $value;
    }

    /**
     * Get location ID
     * @return int
     */
    public function getLocationId()
    {
        return $this->_locationId;
    }

    /**
     * Get data of header
     * @return array
     */
    public function getHeader()
    {
        return array(
            Application_MassUpload_Excel_Constant_ItemMassInsert::ID,
            Application_MassUpload_Excel_Constant_ItemMassInsert::NAME,
            Application_MassUpload_Excel_Constant_ItemMassInsert::DESCRIPTION,
            Application_MassUpload_Excel_Constant_ItemMassInsert::VALUE,
            Application_MassUpload_Excel_Constant_ItemMassInsert::WIDTH,
            Application_MassUpload_Excel_Constant_ItemMassInsert::LENGTH,
            Application_MassUpload_Excel_Constant_ItemMassInsert::HEIGHT,
            Application_MassUpload_Excel_Constant_ItemMassInsert::WEIGHT,
            Application_MassUpload_Excel_Constant_ItemMassInsert::TYPE,
            Application_MassUpload_Excel_Constant_ItemMassInsert::PO_NUMBER,
            Application_MassUpload_Excel_Constant_ItemMassInsert::INBOUND_DATE,
            Application_MassUpload_Excel_Constant_ItemMassInsert::EXPIRED_DATE,
            Application_MassUpload_Excel_Constant_ItemMassInsert::SERIAL,
            Application_MassUpload_Excel_Constant_ItemMassInsert::IMEI,
        );
    }

    /**
     * Get upload file ID
     * @return string
     */
    public function getFileId()
    {
        return 'excel_file';
    }

    /**
     * Get required column for validation
     * @return array
     */
    private function _getRequiredColumn()
    {
        return array(
            Application_MassUpload_Excel_Constant_ItemMassInsert::ID,
            Application_MassUpload_Excel_Constant_ItemMassInsert::NAME,
            Application_MassUpload_Excel_Constant_ItemMassInsert::DESCRIPTION,
            Application_MassUpload_Excel_Constant_ItemMassInsert::VALUE,
            Application_MassUpload_Excel_Constant_ItemMassInsert::WIDTH,
            Application_MassUpload_Excel_Constant_ItemMassInsert::LENGTH,
            Application_MassUpload_Excel_Constant_ItemMassInsert::HEIGHT,
            Application_MassUpload_Excel_Constant_ItemMassInsert::WEIGHT,
            Application_MassUpload_Excel_Constant_ItemMassInsert::TYPE,
        );
    }

    /**
     * Validate each row
     * @param array $row
     * @return null|string
     */
    public function validateRow($row)
    {
        $message = array();
        $requiredColumn = $this->_getRequiredColumn();
        foreach ($requiredColumn as $columnName) {
            if (empty($row[$columnName])) {
                $message[] = sprintf($this->getTranslation('item_mass_insert_validation_null'), $columnName);
            }
        }

        #Validate ID duplicated
        $id = $row[Application_MassUpload_Excel_Constant_ItemMassInsert::ID];
        if ($id) {
            if (!in_array($id, self::$idProduct)) {
                array_push(self::$idProduct, $id);
            } else {
                $message[] = sprintf(
                    $this->getTranslation('item_mass_insert_validation_id_duplicated'),
                    $id
                );
            }

            $sku = Model_Item::getInstance()->generateSku($this->getPartnerId(), $id);
            if (Model_Item::getInstance()->searchBySku($sku)) {
                $message[] = sprintf(
                    $this->getTranslation('item_mass_insert_validation_id_existed'),
                    $id
                );
            }
        }

        #Validate item type
        $type = $row[Application_MassUpload_Excel_Constant_ItemMassInsert::TYPE];
        if ($type) {
            $typeInfo = Model_ItemType::getInstance()->getById($type);
            if (!$typeInfo) {
                $message[] = $this->getTranslation('item_mass_insert_validation_type_not_valid');
            }
        }

        return count($message) ? implode(', ', $message) : null;
    }

    public function processRow($row)
    {
        $message = Model_Item::getInstance()->insert(
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::NAME],
            Model_Item::getInstance()->generateSku(
                $this->getPartnerId(),
                $row[Application_MassUpload_Excel_Constant_ItemMassInsert::ID]
            ),
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::DESCRIPTION],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::PO_NUMBER],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::INBOUND_DATE],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::SERIAL],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::IMEI],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::EXPIRED_DATE],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::VALUE],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::LENGTH],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::WIDTH],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::HEIGHT],
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::WEIGHT],
            Application_Constant_Db_Item_Status::INIT,
            $this->getLocationId(),
            $row[Application_MassUpload_Excel_Constant_ItemMassInsert::TYPE],
            $this->getPartnerId()
        );
        return $message;
    }
}