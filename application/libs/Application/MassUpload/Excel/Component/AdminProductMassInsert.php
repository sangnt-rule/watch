<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/29/16
 * Time: 8:09 PM
 */
class Application_MassUpload_Excel_Component_AdminProductMassInsert extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_partnerId;

    /**
     * @var array
     */
    static $skuData = array();

    /**
     * @var array
     */
    static $skuDuplicated = array();

    /**
     * @var array
     */
    static $skuExisted = array();

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
     * Get data of header
     * @return array
     */
    public function getHeader()
    {
        return array(
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::NAME,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::DESCRIPTION,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::LENGTH,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::WIDTH,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::HEIGHT,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::WEIGHT,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::TYPE,
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
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::NAME,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::LENGTH,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::WIDTH,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::HEIGHT,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::WEIGHT,
            Application_MassUpload_Excel_Constant_AdminProductMassInsert::TYPE,
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

        #Validate Sku
        $sku = $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU];
        if ($sku) {
            $sku = Admin_Model_Product::getInstance()->generateSku($sku, $this->getPartnerId());

            $isDuplicated = false;
            if (in_array($sku, self::$skuData)) {
                $isDuplicated = true;
            }
            if ($isDuplicated) {
                if (!in_array($sku, self::$skuDuplicated)) {
                    $message[] = sprintf(
                        $this->getTranslation('admin_product_mass_insert_validation_sku_duplicated'),
                        $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU]
                    );
                    array_push(self::$skuDuplicated, $sku);
                }
            } else {
                array_push(self::$skuData, $sku);

                #Check if sku exists in db
                $isExisted = false;
                if (in_array($sku, self::$skuExisted)) {
                    $isExisted = true;
                }
                if (!$isExisted) {
                    if (Admin_Model_Product::getInstance()->searchBySku($sku)) {
                        $isExisted = true;
                    }
                }
                if ($isExisted) {
                    if (!in_array($sku, self::$skuExisted)) {
                        $message[] = sprintf(
                            $this->getTranslation('admin_product_mass_insert_validation_sku_exist'),
                            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU]
                        );
                        array_push(self::$skuExisted, $sku);
                    }
                }
                #Check if sku exists in db
            }
        }

        #Validate product type
        $type = $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::TYPE];
        if ($type) {
            $typeInfo = Admin_Model_ProductType::getInstance()->getById($type);
            if (!$typeInfo) {
                $message[] = sprintf(
                    $this->getTranslation('admin_product_mass_insert_validation_type_invalid'),
                    $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU]
                );
            }
        }

        $message = count($message) ? implode(', ', $message) : null;
        return $message;
    }

    public function processRow($row)
    {
        $sku = $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU];
        $sku = Admin_Model_Product::getInstance()->generateSku($sku, $this->getPartnerId());

        $idInserted = Admin_Model_Product::getInstance()->insert(
            $this->getPartnerId(),
            $sku,
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::NAME],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::DESCRIPTION],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::WIDTH],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::LENGTH],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::HEIGHT],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::WEIGHT],
            $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::TYPE]
        );
        $result = '';
        if (!$idInserted) {
            $result = sprintf(
                $this->getTranslation('admin_product_mass_insert_failed'),
                $row[Application_MassUpload_Excel_Constant_AdminProductMassInsert::SKU]
            );
        }
        return $result;
    }
}