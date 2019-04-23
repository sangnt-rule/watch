<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 10:32 AM
 */
interface Application_Constant_Global_Email
{
    /**
     * @var string
     */
    const EMAIL = 'no-reply@pasoto.com';

    /**
     * @var string
     */
    const EMAIL_SUPPORT = 'hotro@pasoto.com';

    /**
     * @var string
     */
    const CONTACT = 'Pasoto Contact';

    /**
     * @var string
     */
    const SENDER = 'Pasoto Admin';

    /**
     * @var string
     */
    const SUBJECT_FORGOT_PASSWORD = 'Mat khau moi';

    /**
     * @var string
     */
    const SUBJECT_NEW_ADMINISTRATOR = 'Thong tin tai khoan quan tri';

    /**
     * @var string
     */
    const SUBJECT_TICKET_CONFIRMATION = 'Xac nhan dat ve thanh cong';

    /**
     * @var string
     */
    const SUBJECT_TICKET_CANCELLED = 'Xac nhan huy ve thanh cong';

    /**
     * @var string
     */
    const SUBJECT_CUSTOMER_CONTACT = 'Thong tin khach hang lien he';

    /**
     * @var string
     */
    const SUBJECT_HOTEL_AGODA_BOOKING_CONFIRMATION = 'Xác nhận đặt phòng tại khách sạn %s - Mã số đơn hàng %s';

    /**
     * @var string
     */
     const SUBJECT_HOTEL_AGODA_BOOKING_INFO ='Thông Tin Đặt Phòng %s Tại Khách Sạn %s ';

    /**
     * @var string
     */
    const SUBJECT_HOTEL_AGODA_CANCELATION_INFO ='Thông báo hủy đơn đặt phòng - Mã số đơn hàng';

    /**
     * @var string
     */
    const SUBJECT_CAR_ORDER_BOOKING = 'Xác Nhận Đơn Hàng %s, Tuyến %s';

    /**
     * @var string
     */
    const SUBJECT_CAR_ORDER_WAITING_FOR_PAY = 'Thông Tin Đơn Hàng %s - Tuyến %s';

    /**
     * @var string
     */
    const SUBJECT_CAR_ORDER_CANCELED_BEFORE_PAID = 'Báo Hủy Đơn Hàng %s - Tuyến %s';

    /**
     * @var string
     */
    const SUBJECT_CAR_ORDER_CANCELED_AFTER_PAID = 'Báo Hủy Đơn Hàng %s - Tuyến %s';

    /**
     * @var string
     */
    const SUBJECT_CAR_THANKS_EMAIL = 'Cám ơn quý khách đã sử dụng dịch vụ thuê xe';

    /**
     * @var string
     */
    const SUBJECT_HOTEL_PRICE_ROOM = 'Báo Giá Tại Khách Sạn %s Giai Đoạn [%s - %s]';

    /**
     * @var string
     */
    const SUBJECT_CAR_ORDER_DRIVER = 'Xác Nhận Đơn Hàng %s, Tuyến %s';

    /**
     * @var string
     */
    const SUBJECT_HOTEL_THANKS_EMAIL = 'Cám ơn quý khách đã sử dụng dịch vụ khách sạn';

    /**
     * @var string
     */
    const SUBJECT_CAR_DRIVER_CANCELLATION = 'Báo Hủy Đơn Hàng %s - Tuyến %s';
}