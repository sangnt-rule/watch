<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/11/15
 * Time: 3:56 PM
 */
interface Application_MassUpload_Excel_Enum
{
    /**
     * @var string
     */
    const ITEM_MASS_INSERT = 'ItemMassInsert';

    /**
     * @var string
     */
    const ADMIN_PURCHASE_ORDER_MASS_UPDATE = 'AdminPurchaseOrderMassUpdate';

    /**
     * @var string
     */
    const ADMIN_PRODUCT_MASS_INSERT = 'AdminProductMassInsert';

    /**
     * @var string
     */
    const ADMIN_ORDERS_MASS_UPDATE = 'AdminOrdersMassUpdate';

    /**
     * @var string
     */
    const ADMIN_PURCHASE_ORDER_MASS_UPDATE_CONFIGURATION = 'AdminPurchaseOrderMassUpdateConfiguration';

    /**
     * @var string
     */
    const ADMIN_ORDERS_MASS_UPDATE_CONFIGURATION = 'AdminOrdersMassUpdateConfiguration';
}