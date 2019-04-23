<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/21/15
 * Time: 4:53 PM
 */
interface Application_Constant_Module_Admin
{
    /**
     * @var string
     */
    const PREFIX_ACL_RESOURCE = 'resource';

    /**
     * @var string
     */
    const PREFIX_ACL_PRIVILEGE = 'privilege';

    /**
     * @var string
     */
    const PREFIX_MENU_NAME = 'name';

    /**
     * @var string
     */
    const PREFIX_MENU_URL = 'url';

    /**
     * @var int
     */
    const LIMIT = 30;

    /**
     * @var string
     */
    const ALIAS_SEAT_TYPE = 'type';

    /**
     * @var string
     */
    const ALIAS_SEAT_LABEL = 'label';

    /**
     * @var string
     */
    const ALIAS_SEAT_ID = 'id';

    /**
     * @var string
     */
    const ACTIVE_VALUE = 'activate';

    /**
     * @var string
     */
    const INACTIVE_VALUE = 'inactivate';

    /**
     * @var string
     */
    const ALIAS_SUB_LOCATION = 'sub_location';

    /**
     * @var string
     */
    const DATA = 'data';

    /**
     * @var string
     */
    const MANUAL_ACTION_DISPLAY_HOMEPAGE = 'display-homepage';

    /**
     * @var string
     */
    const MANUAL_ACTION_UN_DISPLAY_HOMEPAGE = 'un-display-homepage';

    /**
     * @var string
     */
    const MANUAL_ACTION_CATEGORY_ACTIVE = 'category-active';

    /**
     * @var string
     */
    const MANUAL_ACTION_CATEGORY_INACTIVE = 'category-inactive';

    /**
     * @var string
     */
    const MANUAL_ACTION_SUB_CATEGORY_ACTIVE = 'sub-category-active';

    /**
     * @var string
     */
    const MANUAL_ACTION_SUB_CATEGORY_INACTIVE = 'sub-category-inactive';

    /**
     * @var string
     */
    const NEWS_SPONSOR = 'news-sponsor';

    /**
     * @var string
     */
    const NEWS_NO_SPONSOR = 'news-no-sponsor';

    /**
     * @var string
     */
    const SCHEDULE_SPONSOR = 'schedule_sponsor';

    /**
     * @var string
     */
    const SCHEDULE_NO_SPONSOR = 'schedule_no_sponsor';

    /**
     * @var string
     */
    const REPORT_SPONSOR = 'report_sponsor';

    /**
     * @var string
     */
    const REPORT_NO_SPONSOR = 'report_no_sponsor';

    /**
     * @var string
     */
    const SERVICE_SPONSOR = 'service_sponsor';

    /**
     * @var string
     */
    const SERVICE_NO_SPONSOR = 'service_no_sponsor';

    /**
     * @var string
     */
    const CLUB_SPONSOR = 'club_sponsor';

    /**
     * @var string
     */
    const CLUB_NO_SPONSOR = 'club_no_sponsor';

    /**
     * @var string
     */
    const MEMBER_SPONSOR = 'member_sponsor';

    /**
     * @var string
     */
    const MEMBER_NO_SPONSOR = 'member_no_sponsor';

    /**
     * @var string
     */
    const YOUTUBE_UPDATE_ACTIVE = 'youtube_active';

    /**
     * @var string
     */
    const YOUTUBE_UPDATE_INACTIVE = 'youtube_inactive';

    const HORSE_UPDATE_ACTIVE = 'horse_active';

    const HORSE_UPDATE_INACTIVE = 'horse_inactive';
}