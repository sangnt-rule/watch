<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 8/12/2015
 * Time: 7:13 PM
 */
class Application_Controller_Ws extends Application_Controller
{
    /**
     * @var array
     */
    private $_paramInfo;

    /**
     * @var array
     */
    protected $wsInfo;

    /**
     * @var array
     */
    private $_partnerInfo;

    /**
     * @var Zend_Config_Ini
     */
    protected $config;

    public function init()
    {
        $this->config = Zend_Registry::get('config');
    }

    public function preDispatch()
    {
        $controller = $this->getRequest()->getControllerName();
        $action = $this->getRequest()->getActionName();
        $key = $this->getRequest()->getParam('key');
        $param = $this->getRequest()->getParam('data');
        $code = $this->getRequest()->getParam('code');
        $partnerData = Ws_Model_Partner::getInstance()->searchByKey($key);
        if ($partnerData) {
            #Validate secret key
            $codeString = '';
            if ($param) {
                $paramData = json_decode(trim($param), true);
                if ($paramData && is_array($paramData)) {
                    ksort($paramData);
                    foreach ($paramData as $value) {
                        $codeString = $codeString . $value;
                    }
                }
                $this->setWsParamInfo($paramData);
            }
            $codeString = md5($codeString . $partnerData[DbTable_Partner::COL_PARTNER_SECRET_KEY]);
            #Validate secret key

            if ($codeString == $code) {
                #White list IP
                $whiteListIP = Ws_Model_PartnerWhitelist::getInstance()->getByPartnerId(
                    $partnerData[DbTable_Partner::COL_PARTNER_ID]
                );
                $ip = $_SERVER['REMOTE_ADDR'];
                #White list IP

                if ($whiteListIP) {
                    if (Ws_Model_PartnerWhitelist::getInstance()->isApproveAllIP($whiteListIP) || in_array($ip, $whiteListIP)) {
                        $partnerWebserviceData = Ws_Model_PartnerWebservice::getInstance()->searchByPartnerId($partnerData[DbTable_Partner::COL_PARTNER_ID]);
                        if ($partnerWebserviceData) {
                            $webserviceData = Ws_Model_PartnerWebservice::getInstance()->isIncluded($partnerWebserviceData, $controller, $action);
                            if ($webserviceData) {
                                Ws_Model_WebserviceLog::getInstance()->insert(
                                    $webserviceData[DbTable_Webservice::COL_WEBSERVICE_ID],
                                    $partnerData[DbTable_Partner::COL_PARTNER_ID],
                                    $param
                                );
                                $this->_setPartnerInfo($partnerData);
                            } else {
                                $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::PARTNER_PRIVILEGE_INVALID);
                            }
                        } else {
                            $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::PARTNER_PRIVILEGE_INVALID);
                        }
                    } else {
                        $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::WHITE_LIST_IP_INVALID);
                    }
                } else {
                    $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::WHITE_LIST_IP_INVALID);
                }
            } else {
                $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::SECRET_KEY_INVALID);
            }
        } else {
            $this->_responseAccessDenied(Application_Constant_Db_Webservice_Error::API_KEY_INVALID);
        }
    }

    public function postDispatch()
    {
        $this->noRender();
    }

    private function _setPartnerInfo($partnerInfo)
    {
        $this->_partnerInfo = $partnerInfo;
    }

    /**
     * Get partner ID
     * @return null|int
     */
    protected function getPartnerId()
    {
        return isset($this->_partnerInfo[DbTable_Partner::COL_PARTNER_ID]) ? $this->_partnerInfo[DbTable_Partner::COL_PARTNER_ID] : null ;
    }

    private function _responseAccessDenied($errorCode)
    {
        $this->responseWs($errorCode, null);
    }

    protected function setWsParamInfo($data)
    {
        $this->_paramInfo = $data;
    }

    /**
     * Get Ws parameter
     * @param string $key
     * @param null $default
     * @return null|string|int|float
     */
    protected function getWsParamInfo($key, $default=null)
    {
        return isset($this->_paramInfo[$key]) ? $this->_paramInfo[$key] : $default;
    }

    /**
     * Response API result
     * @param int $errorCode
     * @param array|null $data
     */
    protected function responseWs($errorCode, $data)
    {
        $errorData = Ws_Model_WebserviceError::getInstance()->getInfoById($errorCode);
        $this->_helper->json(
            array(
                Application_Constant_Module_Ws::RESPONSE_KEY => $errorCode,
                Application_Constant_Module_Ws::RESPONSE_MESSAGE_KEY => $errorData[DbTable_Webservice_Error::COL_WEBSERVICE_ERROR_MESSAGE],
                Application_Constant_Module_Ws::RESPONSE_DATA => $data
            )
        );
    }


}