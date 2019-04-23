<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/16
 * Time: 3:28 PM
 */
class Application_MassUpload_Excel_Component_AdminPurchaseOrderMassUpdate extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_partnerId;

    /**
     * @var int
     */
    private $_purchaseOrderId;

    /**
     * Set purchase order ID
     * @param int $value
     */
    public function setPurchaseOrderId($value)
    {
        $this->_purchaseOrderId = $value;
    }

    /**
     * Get purchase order ID
     * @return int
     */
    public function getPurchaseOrderId()
    {
        return $this->_purchaseOrderId;
    }

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
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU,
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::QTY,
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::VALUE,
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
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU,
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::QTY,
            Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::VALUE,
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
        $message = count($message) ? '0|'.implode(', ', $message) : null;
        return $message; #Tricky for AdminPurchaseOrderMassUpdate.processResponse
    }

    public function processRow($row)
    {
        $sku = $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU];
        $qty = $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::QTY];
        $value = $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::VALUE];

        $sku = Admin_Model_Product::getInstance()->generateSku($sku, $this->getPartnerId());
        $productInfo = Admin_Model_Product::getInstance()->searchBySku($sku);
        $productId = $productInfo[DbTable_Product::COL_PRODUCT_ID];
        $needToAddProduct = $idPurchaseOrderProduct = 0;
        $message = '';
        $errorCode = 0;
        if ($productId) {
            $idPurchaseOrderProduct = Admin_Model_PurchaseOrderProduct::getInstance()->searchByPurchaseOrderAndProduct($this->getPurchaseOrderId(), $productId);
            if ($idPurchaseOrderProduct) {
                $response = Admin_Model_PurchaseOrderProduct::getInstance()->update($idPurchaseOrderProduct, $qty, $value);
            } else {
                $response = Admin_Model_PurchaseOrderProduct::getInstance()->insert($this->getPurchaseOrderId(), $productId, $qty, $value);
            }
            if ($response) {
                $message = sprintf(
                    $this->getTranslation('admin_purchase_order_mass_update_failed'),
                    $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]
                );
            } else {
                $message = $idPurchaseOrderProduct ? $this->getTranslation('admin_purchase_order_mass_update_success_update') :
                    $this->getTranslation('admin_purchase_order_mass_update_success_add');
                $message = sprintf($message, $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]);
                $errorCode = Application_Constant_Module_Default::RESPONSE_SUCCESSFUL_CODE;
            }
        } else {
            $needToAddProduct = 1;
        }
        $result = sprintf(
            '%s|%s|%s-%s-%s|%d',
            $needToAddProduct,
            $message,
            $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU],
            $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::QTY],
            $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::VALUE],
            $errorCode
        );
        return $result;
    }
}