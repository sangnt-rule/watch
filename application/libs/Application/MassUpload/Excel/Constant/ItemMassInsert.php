<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 5/19/16
 * Time: 4:39 PM
 */
interface Application_MassUpload_Excel_Constant_ItemMassInsert
{
    /**
     * @var string
     */
    const ID = '(*)Id(duy nhat)';

    /**
     * @var string
     */
    const NAME = '(*)Ten - Name';

    /**
     * @var string
     */
    const DESCRIPTION = '(*)Mo Ta - Description';

    /**
     * @var string
     */
    const VALUE = '(*)Tri gia - Value';

    /**
     * @var string
     */
    const WIDTH = '(*)Rong - Width(cm)';

    /**
     * @var string
     */
    const LENGTH = '(*)Dai - Length(cm)';

    /**
     * @var string
     */
    const HEIGHT = '(*)Cao - Height(cm)';

    /**
     * @var string
     */
    const WEIGHT = '(*)Khoi Luong - Weight(kg)';

    /**
     * @var string
     */
    const TYPE = '(*)Loai - Type (1=San pham/Product; 2=Goi hang/Package)';

    /**
     * @var string
     */
    const PO_NUMBER = 'So don PO';

    /**
     * @var string
     */
    const INBOUND_DATE = 'Ngay nhap kho';

    /**
     * @var string
     */
    const EXPIRED_DATE = 'Ngay het han';

    /**
     * @var string
     */
    const SERIAL = 'Serial';

    /**
     * @var string
     */
    const IMEI = 'Imei';
}