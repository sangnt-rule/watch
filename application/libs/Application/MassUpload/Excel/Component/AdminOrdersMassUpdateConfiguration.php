<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/13/16
 * Time: 3:28 PM
 */
class Application_MassUpload_Excel_Component_AdminOrdersMassUpdateConfiguration extends Application_MassUpload_Excel_Abstract
{
    /**
     * @var int
     */
    private $_partnerId;

    /**
     * @var int
     */
    private $_ordersId;

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
        return isset($this->_configuration[DbTable_Orders_Configuration::COL_ORDERS_CONFIGURATION_SKU]) ?
            $this->_configuration[DbTable_Orders_Configuration::COL_ORDERS_CONFIGURATION_SKU] : -1;
    }

    /**
     * Get configuration for Qty
     * @return int
     */
    private function _configurationQty()
    {
        return isset($this->_configuration[DbTable_Orders_Configuration::COL_ORDERS_CONFIGURATION_QTY]) ?
            $this->_configuration[DbTable_Orders_Configuration::COL_ORDERS_CONFIGURATION_QTY] : -1;
    }

    /**
     * Set order ID
     * @param int $value
     */
    public function setOrdersId($value)
    {
        $this->_ordersId = $value;
    }

    /**
     * Get order ID
     * @return int
     */
    public function getOrdersId()
    {
        return $this->_ordersId;
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
            $this->_configurationSku(), $this->_configurationQty()
        );
        $sku = '';
        foreach ($row as $columnName => $value) {
            if (in_array($index, $indexRequiredData)) {
                if (empty($value)) {
                    $message[] = sprintf($this->getTranslation('item_mass_insert_validation_null'), $columnName);
                }
            }
            if ($index == $this->_configurationSku()) {
                $sku = $value;
            }
            $index++;
        }
        if ($sku) {
            $sku = Admin_Model_Product::getInstance()->generateSku($sku, $this->getPartnerId());
            $productInfo = Admin_Model_Product::getInstance()->searchBySku($sku);
            if (!$productInfo) {
                $message[] = sprintf(
                    $this->getTranslation('admin_orders_mass_update_sku_not_exists'),
                    $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]
                );
            }
            /*
            if ($productInfo) {
                $qty = $row[Application_MassUpload_Excel_Constant_AdminOrdersMassUpdate::QTY];
                if ($qty) {
                    $partnerId = $productInfo[DbTable_Product::COL_FK_PARTNER];
                    $locationData = Admin_Model_PartnerLocation::getInstance()->searchPartnerPin($partnerId);
                    if ($locationData) {
                        $productId = $productInfo[DbTable_Product::COL_PRODUCT_ID];
                        $locationId = Application_Function_Array::buildArrayByKey($locationData, DbTable_Location::COL_LOCATION_ID);
                        $itemsInLocation = Admin_Model_Item::getInstance()->countAvailableItem($productId, $locationId);
                        $itemsAssigned = Admin_Model_OrdersProduct::getInstance()->countItemsAssigned($productId);
                        $stock = $itemsInLocation - $itemsAssigned;
                        if ($stock < $qty) {
                            $message[] = sprintf(
                                $this->getTranslation('admin_orders_mass_update_sku_out_of_stock'),
                                $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]
                            );
                        }
                    } else {
                        $message[] = sprintf(
                            $this->getTranslation('admin_orders_mass_update_sku_out_of_stock'),
                            $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]
                        );
                    }
                }
            } else {
                $message[] = sprintf(
                    $this->getTranslation('admin_orders_mass_update_sku_not_exists'),
                    $row[Application_MassUpload_Excel_Constant_AdminPurchaseOrderMassUpdate::SKU]
                );
            }*/
        }
        $message = count($message) ? implode(', ', $message) : null;
        return $message;
    }

    public function processRow($row)
    {
        $skuData = $qtyData = null;
        $index = 1;
        foreach ($row as $data) {
            if ($index == $this->_configurationSku()) {
                $skuData = $data;
            } elseif ($index == $this->_configurationQty()) {
                $qtyData = $data;
            }
            $index++;
        }

        $qty = $qtyData;
        $sku = Admin_Model_Product::getInstance()->generateSku($skuData, $this->getPartnerId());
        $productInfo = Admin_Model_Product::getInstance()->searchBySku($sku);
        $message = '';

        $partnerId = $productInfo[DbTable_Product::COL_FK_PARTNER];
        $locationData = Admin_Model_PartnerLocation::getInstance()->searchPartnerPin($partnerId);
        if ($locationData) {
            $itemsInLocation = Admin_Model_Item::getInstance()->countAvailableItem(
                $productInfo[DbTable_Product::COL_PRODUCT_ID],
                Application_Function_Array::buildArrayByKey($locationData, DbTable_Location::COL_LOCATION_ID)
            );
            $itemsAssigned = Admin_Model_OrdersProduct::getInstance()->countItemsAssigned($productInfo[DbTable_Product::COL_PRODUCT_ID], $this->getOrdersId());
            $stock = $itemsInLocation - $itemsAssigned;

            if ($stock >= $qty) {
                $productId = $productInfo[DbTable_Product::COL_PRODUCT_ID];
                Admin_Model_OrdersProduct::getInstance()->resetProductAssigned($this->getOrdersId(), $productId);
                for ($i=0; $i<$qty; $i++) {
                    Admin_Model_OrdersProduct::getInstance()->insert($this->getOrdersId(), $productId);
                }
            } else {
                $message = sprintf(
                    $this->getTranslation('admin_orders_mass_update_sku_out_of_stock'),
                    $skuData
                );
            }
        } else {
            $message = sprintf(
                $this->getTranslation('admin_orders_mass_update_sku_out_of_stock'),
                $skuData
            );
        }
        return $message;
    }
}