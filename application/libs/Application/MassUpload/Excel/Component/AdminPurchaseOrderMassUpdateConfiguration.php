<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/16
 * Time: 3:28 PM
 */
class Application_MassUpload_Excel_Component_AdminPurchaseOrderMassUpdateConfiguration extends Application_MassUpload_Excel_Abstract
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
     * @var array
     */
    private $_configuration = array();

    /**
     * Set value for _configuration
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->_configuration = $configuration;
    }

    /**
     * Get configuration for SKU
     * @return int
     */
    private function _configurationSku()
    {
        return isset($this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_SKU]) ?
            $this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_SKU] : -1;
    }

    /**
     * Get configuration for Qty
     * @return int
     */
    private function _configurationQty()
    {
        return isset($this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_QTY]) ?
            $this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_QTY] : -1;
    }

    /**
     * Get configuration for Price
     * @return int
     */
    private function _configurationPrice()
    {
        return isset($this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_VALUE]) ?
            $this->_configuration[DbTable_Purchase_Order_Configuration::COL_PURCHASE_ORDER_CONFIGURATION_VALUE] : -1;
    }

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
        return array();
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
     * Validate each row
     * @param array $row
     * @return null|string
     */
    public function validateRow($row)
    {
        $message = array();
        $index = 1;
        $indexRequiredData = array(
            $this->_configurationSku(), $this->_configurationQty(), $this->_configurationPrice()
        );
        foreach ($row as $columnName => $value) {
            if (in_array($index, $indexRequiredData)) {
                if (empty($value)) {
                    $message[] = sprintf($this->getTranslation('item_mass_insert_validation_null'), $columnName);
                }
            }
            $index++;
        }

        $message = count($message) ? '0|'.implode(', ', $message) : null;
        return $message; #Tricky for AdminPurchaseOrderMassUpdate.processResponse
    }

    public function processRow($row)
    {
        $skuData = $qtyData = $valueData = null;
        $index = 1;
        foreach ($row as $data) {
            if ($index == $this->_configurationSku()) {
                $skuData = $data;
            } elseif ($index == $this->_configurationQty()) {
                $qtyData = $data;
            } elseif ($index == $this->_configurationPrice()) {
                $valueData = $data;
            }
            $index++;
        }

        $qty = $qtyData;
        $value = $valueData;
        $sku = Admin_Model_Product::getInstance()->generateSku($skuData, $this->getPartnerId());
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
                    $skuData
                );
            } else {
                $message = $idPurchaseOrderProduct ? $this->getTranslation('admin_purchase_order_mass_update_success_update') :
                    $this->getTranslation('admin_purchase_order_mass_update_success_add');
                $message = sprintf($message, $skuData);
                $errorCode = Application_Constant_Module_Default::RESPONSE_SUCCESSFUL_CODE;
            }
        } else {
            $needToAddProduct = 1;
        }
        $result = sprintf(
            '%s|%s|%s-%s-%s|%d',
            $needToAddProduct,
            $message,
            $skuData,
            $qtyData,
            View_Filter_Db_PurchaseOrder_Product_Value::getInstance()->filter($valueData),
            $errorCode
        );
        return $result;
    }
}