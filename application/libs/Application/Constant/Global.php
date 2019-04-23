<?php
interface Application_Constant_Global
{
    const KEY_PREFIX = 'prefix';

    const KEY_DATA = 'data';

    const KEY_TOTAL = 'total';

    const KEY_TOTAL_SOLD = 'total_sold';

    const KEY_AMOUNT_TICKET = 'amount_ticket';

    const KEY_AMOUNT_TICKET_VOUCHER = 'amount_ticket_voucher';

    const KEY_AMOUNT_SEAT = 'amount_seat';

    const KEY_AMOUNT_SEAT_VOUCHER = 'amount_seat_voucher';

    const KEY_DATE = 'date';

    const KEY_TOTAL_PAGE = 'totalPage';

    const KEY_POUNDAGE = 'poundage';

    const PARAM_PAGE = 'page';

    const SYSTEM_MAIL_EMAIL = 'no-reply@localhost.com';

    const SYSTEM_MAIL_SENDER = 'Administrator';

    const KEY_CODE = 'code';

    const KEY_ID = 'ID';

    const GENDER_MALE = 1;

    const GENDER_FEMALE = 2;

    const GENDER_MALE_TEXT = 'Nam';

    const GENDER_FEMALE_TEXT = 'Nữ';

    const ALIAS_STATION_FROM = 'station_from';

    const ALIAS_STATION_PROVINCE_FROM = 'station_province_from';

    const ALIAS_STATION_CODE_FROM = 'station_code_from';

    const ALIAS_STATION_NAME_FROM = 'station_name_from';

    const ALIAS_STATION_TO = 'station_to';

    const ALIAS_STATION_CODE_TO = 'station_code_to';

    const ALIAS_STATION_NAME_TO = 'station_name_to';

    const ALIAS_STATION_PROVINCE_TO = 'station_province_to';

    const ALIAS_TOTAL_TICKET_AVAILABLE = 'total_ticket_available';

    /**
     * @var string
     */
    const QTY_CHEAP_TICKET = 'qty_cheap_ticket';

    /**
     * @var string
     */
    const COMPANY_INFO = 'company_info';

    /**
     * @var string
     */
    const PROVINCE_FROM = 'province_from';

    /**
     * @var string
     */
    const PROVINCE_TO = 'province_to';

    /**
     * @var string
     */
    const TRIP_INFO = 'trip_info';

    /**
     * @var string
     */
    const SEAT_DATA = 'seat_data';

    /**
     * @var string
     */
    const LOCALE_VI = 'vi';

    /**
     * @var string
     */
    const LOCALE_EN = 'en';

    /**
     * @var string
     */
    const PATTERN_DATE = 'd/m/Y';

    /**
     * Time for pickup preparation for next day
     * @var int
     */
    const PICKUP_ESTIMATION = 8;

    /**
     * @var string
     */
    const REF_NOTE = 'Discount %d (percent) for first order.';

    /**
     * @var int
     */
    const MAXIMUM_PROMOTION_SEAT = 2;

    /**
     * @var string
     */
    const MYSQL_DATE_NULL = '0000-00-00';

    /**
     * Cookie key of customer
     * @var string
     */
    const COOKIE_CUSTOMER = 'COOKIE_CUSTOMER';

    /**
     * @var string
     */
    const ACCESS_DENIED = 'Access Denied';

    /**
     * Cookie key of company
     * @var string
     */
    const COOKIE_COMPANY = 'COOKIE_COMPANY';

    /**
     * @var int
     */
    const PERCENT_NEW_YEAR_SEAT = 80;

    /**
     * @var string
     */
    const KEY_PAGINATION = "pagination";

    /**
     * @var string
     */
    const SAI_GON = "sài gòn";

    /**
     * @var string
     */
    const KEY_CAR_ROUTE_FROM_TO = 'car_route_from_to';

    /**
     * @var string
     */
    const ALIAS_PROVINCE_FROM = 'province_from';

    /**
     * @var string
     */
    const ALIAS_PROVINCE_TO = 'province_to';

    /**
     * @var string
     */
    const TRANSACTION_PREFIX_BUS = 'BUS';

    /**
     * @var string
     */
    const TRANSACTION_PREFIX_CAR = 'CAR';

    /**
     * @var string
     */
    const TRANSACTION_PREFIX_PLANE = 'PLA';

    /**
     * @var string
     */
    const TRANSACTION_PREFIX_HOTEL = 'HOT';


    /**
     * @var string
     */
    const TICKET_PREFIX_BUS = 'PAS';

    /**
     * @var string
     */
    const TICKET_PREFIX_CAR = 'PAS-TX';

    /**
     * @var string
     */
    const TICKET_PREFIX_HOTEL = 'PAS-KS';

    /**
     * ve may bay dang hoat dong
     * @var int
     */
    const PLANE_MAINTENANCE = 1;

    /**
     * @var string
     */
    const ALIAS_COUNT_CAR_ORDER = 'num_car_order';

    /**
     * @var string
     */
    const ALIAS_LATEST_NOTE_CAR_ORDER = 'last_note';

    /**
     * @var string
     */
    const ALIAS_USER_LATEST_UPDATE_CAR_ORDER = 'user_latest_update';

    /**
     * @string
     */
    const KEY_DISCOUNT = 'discount';

    /**
     * @var string
     */
    const ALIAS_DUMMY_TABLE = 'dummy_table';

    /**
     * @var string
     */
    const ALIAS_TABLE_1 = 'table_1';

    /**
     * @var string
     */
    const ALIAS_TABLE_2 = 'table_2';

    /**
     * @var string
     */
    const COOKIE_PARTNER = 'COOKIE_PARTNER';

    /**
     * @var string
     */
    const DEFAULT_MYSQL_DATE = '0000-00-00 00:00:00';

    const PRINT_SKU_INTERNAL_FIRST_CHAR = 'AAW';
}