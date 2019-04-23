<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 4/5/2016
 * Time: 2:25 PM
 */
class Application_Controller_FrontEnd_Payment123Pay extends Application_Controller_FrontEnd
{

    /**
     * Build IBanking Url for 123 pay
     * @return mixed
     */
    public function buildBankingUrl($ticketCode, $paymentType, $totalAmount)
    {
        $config = $this->getConfig();
        $bankingConfig = $this->getConfigBanking123Pay($paymentType);
        $preFix = substr($ticketCode, 0, 6);

        if ($preFix == Application_Constant_Global::TICKET_PREFIX_HOTEL) {
            $ticketId = Model_HotelAgodaOrder::getInstance()->decode($ticketCode);
            Model_HotelAgodaOrder::getInstance()->updateStatusAndPaymentType($ticketId, Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_PROCESSING_123PAY, $paymentType);
            $preFix = Application_Constant_Global::TRANSACTION_PREFIX_HOTEL;

        } elseif ($preFix == Application_Constant_Global::TICKET_PREFIX_CAR) {

            $ticketId = Model_CarOrder::getInstance()->decode($ticketCode);
            $preFix = Application_Constant_Global::TRANSACTION_PREFIX_CAR;
            Model_CarOrder::getInstance()->updateStatus($ticketId, Application_Constant_Db_Config_Car_Status::PROCESSING_123_PAY);

        } else {
            $ticketId = Model_Ticket::getInstance()->decode($ticketCode);
            Model_Ticket::getInstance()->updateStatus($ticketId, Application_Constant_Db_Config_Ticket_Status::TRANSACTION_PROCESSING_123PAY);
            $preFix = Application_Constant_Global::TRANSACTION_PREFIX_BUS;
        }

        $currentUrl = Application_Function_Common::currentUrl();
        $returnUrl = sprintf('%s/payment123-pay/payment-banking-done', $currentUrl);
        $mTransactionID = sprintf('%s%s%s', $preFix, date('YmdHis'), $ticketCode);

        $response = array(
            $config->_123pay->mTransactionID => $mTransactionID,
            $config->_123pay->merchantCode => $config->_123pay->merchant_code,
            $config->_123pay->bankCode => $bankingConfig->bankCode,
            $config->_123pay->totalAmount => $totalAmount,
            $config->_123pay->clientIP => $_SERVER['REMOTE_ADDR'],
            $config->_123pay->custName => "",
            $config->_123pay->custAddress => "",
            $config->_123pay->custGender => "U",
            $config->_123pay->custDOB => "",
            $config->_123pay->custPhone => "",
            $config->_123pay->custMail => "",
            $config->_123pay->description => $ticketCode,
            $config->_123pay->cancelURL => $returnUrl,
            $config->_123pay->redirectURL => $returnUrl,
            $config->_123pay->errorURL => $returnUrl,
            $config->_123pay->passcode => $config->_123pay->pass_code,
            $config->_123pay->checksum => "",
            $config->_123pay->addInfo => "",
        );

        $configData = array(
            $config->_123pay->url => $config->_123pay->urlCreateOrder,
            $config->_123pay->createSecretKey => $config->_123pay->key,
            $config->_123pay->passcode =>  $config->_123pay->pass_code,
            $config->_123pay->cancelURL => $returnUrl, //fill cancelURL here
            $config->_123pay->redirectURL => $returnUrl, //fill redirectURL here
        );

        #Log transaction
        Model_123payTransaction::getInstance()->insert($ticketCode, $mTransactionID, json_encode($response), json_encode($config));
        #Log transaction

        $result = $this->callRest($configData, $response);//call 123Pay service

        if ($result['httpcode'] == 200) {
            //call service success do success flow
            if ($result[0] == '1')//service return success
            {
                //re-create checksum
                $rawReturnValue = '1' . $result[1] . $result[2];
                $reCalChecksumValue = sha1($rawReturnValue . $configData['key']);
                if ($reCalChecksumValue == $result[3]) {
                    header('Location: '.$result[2]);
                }
            }
        }
    }

    #payment Done 123pay
    protected function paymentBankingDone()
    {
        $config = $this->getConfig();
        $mTransactionID = $this->getRequest()->getParam('transactionID');
        $time = $this->getRequest()->getParam('time');
        $status = $this->getRequest()->getParam('status');
        $ticket = $this->getRequest()->getParam('ticket');
        $secretKey = $config->_123pay->key;
        $prefix = substr($mTransactionID, 0, 3);
        $checkSum = md5($status . $time . $mTransactionID . $secretKey);

        if ($ticket != $checkSum) {
            $this->goto404();
        }

        $response = array (
            $config->_123pay->mTransactionID => $mTransactionID,
            $config->_123pay->merchantCode => $config->_123pay->merchant_code,
            $config->_123pay->clientIP => $_SERVER['REMOTE_ADDR'],
            $config->_123pay->passcode => $config->_123pay->pass_code,
            $config->_123pay->checksum => '',
        );

        $configData = array (
            $config->_123pay->url => $config->_123pay->urlQueryOrder,
            $config->_123pay->createSecretKey => $config->_123pay->key,
            $config->_123pay->passcode => $config->_123pay->pass_code,
        );

        $result = $this->callRest($configData, $response);
        if ($result) {
            #log transaction
            Model_123payTransaction::getInstance()->updateQuery(
                $mTransactionID,
                $result[Application_Constant_Global_ResponseData123pay::BANK_CODE],
                $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS],
                $result[Application_Constant_Global_ResponseData123pay::RETURN_CODE],
                $result[Application_Constant_Global_ResponseData123pay::DESCRIPTION],
                $_SERVER['QUERY_STRING']
            );
            #log transaction]
            if ($result[Application_Constant_Global_ResponseData123pay::RETURN_CODE] === 1 || $result[Application_Constant_Global_ResponseData123pay::RETURN_CODE] == '1') {
                #payment type
                $visaBankCode = $config->_123pay->visa->bankCode;
                $paymentType = Application_Constant_Db_Config_Payment::ATM_123PAY;
                if ($result[Application_Constant_Global_ResponseData123pay::BANK_CODE] == $visaBankCode) {
                    $paymentType = Application_Constant_Db_Config_Payment::DEBIT_123PAY;
                }
                #payment type

                if ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_BUS) {
                    $this->processOrderBus($mTransactionID, $result, $paymentType);
                } elseif ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_HOTEL) {
                    $this->processOrderHotel($mTransactionID, $result, $paymentType);
                } elseif ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_CAR) {
                    $this->processOrderCar($mTransactionID, $result, $paymentType);
                }
            }
        }
        $this->goto404();
    }

    /**
     * process bus order (123pay)
     * @param string $mTransactionID
     * @param array $result
     * @param string $paymentType
     */
    protected function processOrderBus($mTransactionID, $result, $paymentType)
    {
        $ticketData = Model_Ticket::getInstance()->searchBySessionID($this->getSessionId());
        $ticketData = current($ticketData);
        $ticketEncode = Model_Ticket::getInstance()->encode($ticketData[DbTable_Ticket::COL_TICKET_ID]);
        if ($ticketData && $this->validateTransactionIDBus($mTransactionID, $ticketEncode)) {

            if ($this->validateNotifySuccessfulBus($ticketData[DbTable_Ticket::COL_FK_CONFIG_TICKET_STATUS])) {
                $this->gotoUrl(
                    sprintf('/ve-xe/thanh-toan/thanh-cong.html/?id=%s', $ticketEncode)
                );
            } elseif ($ticketData[DbTable_Ticket::COL_FK_CONFIG_TICKET_STATUS] == Application_Constant_Db_Config_Ticket_Status::TRANSACTION_FAILED_123PAY) {
                Model_Ticket::getInstance()->updateStatus(
                    $ticketData[DbTable_Ticket::COL_TICKET_ID],
                    Application_Constant_Db_Config_Ticket_Status::HOLDING
                );
                $this->gotoUrl(sprintf('/ve-xe/thanh-toan/khong-thanh-cong.html'));
            } else {
                if ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 1 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '1') {
                    $ticketEncode = Model_Ticket::getInstance()->encode($ticketData[DbTable_Ticket::COL_TICKET_ID]);
                    $this->paymentSuccessBankingBus($ticketData, $paymentType);
                    $this->gotoUrl(
                        sprintf('/ve-xe/thanh-toan/thanh-cong.html/?id=%s', $ticketEncode)
                    );

                } elseif ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 20 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '20') {

                    Model_Ticket::getInstance()->updateStatus(
                        $ticketData[DbTable_Ticket::COL_TICKET_ID],
                        Application_Constant_Db_Config_Ticket_Status::TRANSACTION_WAITING_123PAY
                    );
                    $this->gotoUrl(
                        sprintf(
                            '/ve-xe/thanh-toan/giao-dich-dang-xu-ly.html/?id=%s',
                            $ticketEncode
                        )
                    );

                } else {

                    Model_Ticket::getInstance()->updateStatus(
                        $ticketData[DbTable_Ticket::COL_TICKET_ID],
                        Application_Constant_Db_Config_Ticket_Status::HOLDING
                    );
                    $this->gotoUrl('/ve-xe/thanh-toan');
                }
            }
        } else {
            $this->gotoUrl('/ve-xe/thanh-toan/het-han/');
        }
    }

    /**
     * validate notify successful bus
     * @param int $ticketStatus
     * @return bool
     */
    protected function validateNotifySuccessfulBus($ticketStatus)
    {
        $result = false;
        $statusSuccessArr = array(
            Application_Constant_Db_Config_Ticket_Status::ORDERED,
            Application_Constant_Db_Config_Ticket_Status::CONFIRMED_COMPANY,
            Application_Constant_Db_Config_Ticket_Status::DELIVERY_SUCCESSFUL
        );
        if (in_array($ticketStatus, $statusSuccessArr)) {
            $result = true;
        }
        return $result;
    }

    public function notifyBanking123pay()
    {
        $mTransactionID = $this->getRequest()->getParam('mTransactionID');
        $bankCode = $this->getRequest()->getParam('bankCode');
        $transactionStatus = $this->getRequest()->getParam('transactionStatus');
        $ts = $this->getRequest()->getParam('ts');
        $checksum = $this->getRequest()->getParam('checksum');
        $description = $this->getRequest()->getParam('description');
        $notifyData = array(
            'mTransactionID' => $mTransactionID,
            'bankCode' => $bankCode,
            'transactionStatus' => $transactionStatus,
            'ts' => $ts,
            'checksum' => $checksum,
            'description' => $description
        );
        $ticketId = null;
        $component = 0;
        $prefix = substr($mTransactionID, 0, 3);
        $ticketEncode = substr($mTransactionID, 17);

        if ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_BUS) {
            $component = Application_Constant_Db_Config_Component::BUS;
            $ticketId = Model_Ticket::getInstance()->decode($ticketEncode);
        } elseif ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_HOTEL) {
            $component = Application_Constant_Db_Config_Component::HOTEL;
            $ticketId = Model_HotelAgodaOrder::getInstance()->decode($ticketEncode);
        } elseif ($prefix == Application_Constant_Global::TRANSACTION_PREFIX_CAR) {
            $component = Application_Constant_Db_Config_Component::CAR;
            $ticketId = Model_CarOrder::getInstance()->decode($ticketEncode);
        }
        if ($component && $ticketId) {
            $config = $this->getConfig();
            $result = Application_Function_Notify123pay::validateNotify123Pay($mTransactionID, $bankCode, $transactionStatus, $ts, $checksum, $config->_123pay->key);
            $returnCode = 1;
            $visaBankCode = $config->_123pay->visa->bankCode;
            $paymentType = Application_Constant_Db_Config_Payment::ATM_123PAY;
            if ($bankCode == $visaBankCode) {
                $paymentType = Application_Constant_Db_Config_Payment::DEBIT_123PAY;
            }

            if ($mTransactionID && $bankCode && $transactionStatus && $ts && $checksum) {
                if ($result && $transactionStatus != '-20' && $transactionStatus != '10' && $transactionStatus != '7210' ) {
                    if ($component == Application_Constant_Db_Config_Component::BUS) {
                        $ticketData = Model_Ticket::getInstance()->searchById($ticketId);
                        $ticketInfo = $ticketData->current();
                        if ($ticketInfo->{DbTable_Ticket::COL_FK_CONFIG_TICKET_STATUS} == Application_Constant_Db_Config_Ticket_Status::TRANSACTION_PROCESSING_123PAY || $ticketInfo->{DbTable_Ticket::COL_FK_CONFIG_TICKET_STATUS} == Application_Constant_Db_Config_Ticket_Status::TRANSACTION_WAITING_123PAY) {
                            $returnCode = $this->processNotifyBankingBus($ticketInfo->{DbTable_Ticket::COL_TICKET_ID}, $transactionStatus);
                            if ($returnCode == 1 && $transactionStatus == '1') {
                                $this->paymentSuccessBankingBus($ticketId, $paymentType);
                            }
                        }
                    } elseif ($component == Application_Constant_Db_Config_Component::HOTEL) {
                        $ticketData = Model_HotelAgodaOrder::getInstance()->getById($ticketId);
                        $ticketInfo = $ticketData->current();
                        if ($ticketInfo->{DbTable_Hotel_Agoda_Order::COL_FK_CONFIG_HOTEL_ORDER_STATUS} == Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_PROCESSING_123PAY
                            || $ticketInfo->{DbTable_Hotel_Agoda_Order::COL_FK_CONFIG_HOTEL_ORDER_STATUS} == Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_WAITING_123PAY) {

                            $returnCode = $this->processNotifyBankingHotel($ticketId, $transactionStatus);
                            if($returnCode == 1 && $transactionStatus == '1'){
                                $this->paymentSuccessBankingHotel($ticketId, $paymentType);
                            }
                        }
                    } elseif ($component == Application_Constant_Db_Config_Component::CAR) {
                        $ticketInfo = Model_CarOrder::getInstance()->getById($ticketId);
                        $routeModelInfo = Model_CarRouteModel::getInstance()->getInfoById($ticketInfo->{DbTable_Car_Order::COL_FK_CAR_ROUTE_MODEL});
                        if ($ticketInfo->{DbTable_Car_Order::COL_FK_CONFIG_CAR_STATUS} == Application_Constant_Db_Config_Car_Status::PROCESSING_123_PAY
                            || $ticketInfo->{DbTable_Car_Order::COL_FK_CONFIG_CAR_STATUS} == Application_Constant_Db_Config_Car_Status::PENDING_123_PAY) {

                            $returnCode = $this->processNotifyBankingCar($ticketId, $transactionStatus);
                            if($returnCode == 1 && $transactionStatus == '1'){
                                $this->paymentSuccessBankingCar($ticketInfo, $routeModelInfo);
                            }
                        }
                    }
                } else {
                    $returnCode = -1;
                }
                Model_123payTransaction::getInstance()->updateNotify($mTransactionID, $bankCode, $transactionStatus, $ts, $returnCode, $description, http_build_query($notifyData));
                Application_Function_Notify123pay::response($mTransactionID, $returnCode, $config->_123pay->key);
            }

        }
        $this->noRender();
    }

    /**
     * process notify banking for bus
     * @param int $ticketId
     * @param int $transactionStatus
     * @return int
     */
    protected function processNotifyBankingBus($ticketId, $transactionStatus)
    {
        $returnCode = 1;
        $message = null;
        if ($transactionStatus == 1) {
            $ticketStatus = Application_Constant_Db_Config_Ticket_Status::TRANSACTION_SUCCESSFUL_123PAY;
        } else {
            $ticketStatus = Application_Constant_Db_Config_Ticket_Status::TRANSACTION_FAILED_123PAY;
        }
        $message = Model_Ticket::getInstance()->updateStatus($ticketId, $ticketStatus);
        if ($message) {
            $returnCode = -3;
        }
        return $returnCode;
    }

    /**
     * process success banking for bus
     * @param int $ticketId
     * @param string $paymentType
     */
    public function paymentSuccessBankingBus($ticketId, $paymentType)
    {
        $ticketData = Model_Ticket::getInstance()->searchById($ticketId);
        #Start update payment status
        Model_Ticket::getInstance()->updateStatusAndPaymentType(
            $ticketId,
            Application_Constant_Db_Config_Ticket_Status::ORDERED,
            $paymentType
        );
        $this->cleanUpSessionId();
        #End update payment status
        $emailId = $this->getIdEmailConfirmation();
        $this->sendNotification($emailId, $ticketId);
        $this->proceedOrderedTicket($ticketData);
    }


    /**
     * validate transaction with ticke id array for BUS (123pay)
     * @param string $transactionID
     * @param int $ticketEncode
     * @return bool
     */
    protected function validateTransactionIDBus($transactionID, $ticketEncode)
    {
        $encode = substr($transactionID, 17);
        return $ticketEncode == $encode;
    }

		/**
     * process hotel booking (123pay)
     * @param string $mTransactionID
     * @param string $paymentType
     * @param array $result
     */
    protected function processOrderHotel($mTransactionID, $result, $paymentType){
        $encode = substr($mTransactionID, 17);
        $id = Model_HotelAgodaOrder::getInstance()->decode($encode);
        if ($id) {
            $orderData = Model_HotelAgodaOrder::getInstance()->getFullDetail($id);
            if ($orderData) {
                if ($orderData->{DbTable_Hotel_Agoda_Order::COL_FK_CONFIG_HOTEL_ORDER_STATUS} == Application_Constant_Db_Config_Hotel_Order_Status::PAID) {
                    $this->gotoUrl(sprintf('/khach-san/thanh-toan/thanh-cong.html/?transactionID=%s', $mTransactionID));
                } elseif ($orderData->{DbTable_Hotel_Agoda_Order::COL_FK_CONFIG_HOTEL_ORDER_STATUS} == Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_FAILED_123PAY) {
                    $this->gotoUrl(sprintf('/khach-san/thanh-toan/khong-thanh-cong.html?transactionID=%s', $mTransactionID));
                } else {
                    if ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 1 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '1') {
                        Model_HotelAgodaOrder::getInstance()->updateStatus($id, Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_SUCCESS_123PAY);
                        $this->paymentSuccessBankingHotel($id, $paymentType);
                        $this->gotoUrl(sprintf('/khach-san/thanh-toan/thanh-cong.html/?transactionID=%s', $mTransactionID));
                    } elseif ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 20 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '20') {
                        Model_HotelAgodaOrder::getInstance()->updateStatus($id, Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_WAITING_123PAY);
                        $this->gotoUrl(sprintf('/khach-san/thanh-toan/giao-dich-dang-xu-ly.html?transactionID=%s', $mTransactionID));
                    } else{
                        Model_HotelAgodaOrder::getInstance()->updateStatus($id, Application_Constant_Db_Config_Hotel_Order_Status::WAITING_FOR_PAY);
                        $this->gotoUrl('/khach-san/thanh-toan/?encode=' . $encode);
                    }
                }
            }
        }
    }

    /**
     * Processing order car
     * @param string $mTransactionID
     * @param array $result
     * @param string $paymentType
     */
    protected function processOrderCar($mTransactionID, $result, $paymentType){
        $encode = substr($mTransactionID, 17);
        $id = Model_CarOrder::getInstance()->decode($encode);
        if ($id) {
            $orderData = Model_CarOrder::getInstance()->getById($id);
            $statusOrder = $orderData->{DbTable_Car_Order::COL_FK_CONFIG_CAR_STATUS};
            $extra = $this->_helper->findWeekendFromToDate(
                $orderData->{DbTable_Car_Order::COL_CAR_ORDER_START_DATE},
                $orderData->{DbTable_Car_Order::COL_CAR_ORDER_RETURN_DAY}
            );
            $urlSuccess = sprintf(
                '/thue-xe/thanh-toan/thanh-cong.html?order=%s&extra=%s',
                $encode,
                $extra
            );
            $urlFail = sprintf(
                '/thue-xe/thanh-toan/khong-thanh-cong.html?order=%s',
                $encode
            );
            $urlPending = sprintf(
                '/thue-xe/thanh-toan/dang-giao-dich-123-pay.html?order=%s',
                $encode
            );
            $routeModelInfo = Model_CarRouteModel::getInstance()->getInfoById($orderData->{DbTable_Car_Order::COL_FK_CAR_ROUTE_MODEL});
            if ($orderData) {
                if ($statusOrder == Application_Constant_Db_Config_Car_Status::SUCCESS_PAY) {
                    $this->paymentSuccessBankingCar($orderData, $routeModelInfo);
                    $this->gotoUrl($urlSuccess);
                } elseif ($statusOrder == Application_Constant_Db_Config_Car_Status::FAILED_123_PAY) {
                    $this->gotoUrl($urlFail);
                } else {
                    if ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 1 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '1') {
                        $this->paymentSuccessBankingCar($orderData, $routeModelInfo);
                        $this->gotoUrl($urlSuccess);
                    } elseif ($result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] === 20 || $result[Application_Constant_Global_ResponseData123pay::TRANSACTION_STATUS] == '20') {
                        Model_CarOrder::getInstance()->updateStatus($id, Application_Constant_Db_Config_Car_Status::PENDING_123_PAY);
                        $this->gotoUrl($urlPending);
                    } else{
                        Model_CarOrder::getInstance()->updateStatus($id, Application_Constant_Db_Config_Car_Status::INIT_ORDER);
                        $this->gotoUrl(
                            $this->_helper->buildURLPaymentCar(
                                $routeModelInfo->{DbTable_Car_Route::COL_CAR_ROUTE_FROM},
                                $routeModelInfo->{DbTable_Car_Route::COL_CAR_ROUTE_TO},
                                $routeModelInfo->{DbTable_Car_Model::COL_CAR_MODEL_INDENTIFY},
                                $orderData->{DbTable_Car_Order::COL_CAR_ORDER_TRIP},
                                $orderData->{DbTable_Car_Order::COL_CAR_ORDER_START_DATE},
                                $orderData->{DbTable_Car_Order::COL_CAR_ORDER_RETURN_DAY}
                            )
                        );
                    }
                }
            }
        }
    }

    /**
     * Payment success banking car
     * @param Zend_Db_Table_Row_Abstract $orderData
     * @param Zend_Db_Table_Row_Abstract $detailRoute
     */
    protected function paymentSuccessBankingCar($orderData, $detailRoute)
    {
        Model_CarOrder::getInstance()->updateStatus(
            $orderData->{DbTable_Car_Order::COL_CAR_ORDER_ID},
            Application_Constant_Db_Config_Car_Status::SUCCESS_PAY
        );
        $this->sendNotificationSuccessCar($orderData, $detailRoute);
    }

    /**
     * Send notification success car
     * @param Zend_Db_Table_Row_Abstract $orderData
     * @param Zend_Db_Table_Row_Abstract $detailRoute
     */
    protected function sendNotificationSuccessCar($orderData, $detailRoute)
    {
        $view = $this->view;
        $view->assign(
            'customerNameConvertNoVN',
            Application_Function_String::convertNoVn($orderData->{DbTable_Car_Order::COL_CAR_ORDER_CUSTOMER_NAME})
        );
        $view->assign(
            'area',
            $detailRoute->{DbTable_Car_Route::COL_FK_CAR_AREA}
        );
        $view->assign('detailRoute', $detailRoute);
        $view->assign('orderId', Model_CarOrder::getInstance()->encode($orderData->{DbTable_Car_Order::COL_CAR_ORDER_ID}));

        # send sms customer
        $view->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/mail-templates/');
        $smsContentGuest = $view->render('sms/car-order-notification-success-guest.phtml');
        $this->doSendSms(
            $orderData->{DbTable_Car_Order::COL_CAR_ORDER_CUSTOMER_PHONE},
            $smsContentGuest,
            time()
        );
        # send sms customer
    }

    /**
     * process success payment for hotel (123pay)
     * @param int $id
     * @param string $paymentType
     */
    protected function paymentSuccessBankingHotel($id, $paymentType)
    {
        $orderData = Model_HotelAgodaOrder::getInstance()->getFullDetail($id);

        #Start update payment status
        Model_HotelAgodaOrder::getInstance()->updateStatusAndPaymentType(
            $orderData->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_ID},
            Application_Constant_Db_Config_Hotel_Order_Status::PAID,
            $paymentType
        );
        #End update payment status

        # calculate discount for customer
        $this->processOrderPaid($orderData->{DbTable_Hotel_Agoda_Order::COL_FK_CUSTOMER}, $id);

        # send mail to customer and hotel;
        $this->sendHotelNotificationForCustomer($orderData);
        $this->sendHotelNotificationForHotel($orderData);

    }

    /**
     * confirm booking hotel for customer
     * @param Zend_Db_Table_Row_Abstract $agodaOrder
     */
    protected function sendHotelNotificationForCustomer($agodaOrder){
        if ($agodaOrder) {
            $encode = Model_HotelAgodaOrder::getInstance()->encode($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_ID});
            $customerEmail = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_EMAIL};
            $customerName = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_NAME};
            $this->calculatePriceForCustomer($agodaOrder);
            $view = $this->view;
            $view->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/mail-templates/');
            $view->assign('encode', $encode);
            $view->assign('agodaOrder', $agodaOrder);
            $content = $view->render('hotel-agoda/confirm-customer-paid.phtml');
            $view->assign('emailContent', $content);
            $body = $view->render('layout.phtml');

            $subject = sprintf(
                Application_Constant_Global_Email::SUBJECT_HOTEL_AGODA_BOOKING_CONFIRMATION,
                $agodaOrder->{DbTable_Hotel::COL_HOTEL_NAME},
                $encode
            );
            $this->doSendMail(
                $customerEmail,
                $customerName,
                $subject,
                $body
            );
            # send sms to customer
            $smsPaymentSuccess = $view->render('sms/hotel-order-payment-done.phtml');
            $this->doSendSms(
                $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_PHONE},
                $smsPaymentSuccess,
                time()
            );
            unset($view);
        }
    }

    /**
     * confirm booking hotel for hotel
     * @param Zend_Db_Table_Row_Abstract $agodaOrder
     */
    public function sendHotelNotificationForHotel($agodaOrder){
        if ($agodaOrder) {
            $encode = Model_HotelAgodaOrder::getInstance()->encode($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_ID});
            $this->calculatePriceForHotel($agodaOrder);

            $view = $this->view;
            $view->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/mail-templates/');

            $view->assign('encode', $encode);
            $view->assign('agodaOrder', $agodaOrder);
            $content = $view->render('hotel-agoda/confirm-hotel.phtml');
            $view->assign('emailContent', $content);
            $body = $view->render('layout.phtml');
            unset($view);
            $fkHotel = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_FK_HOTEL};
            $contactList = Model_HotelContact::getInstance()->getAllEmailByFkHotel($fkHotel);
            $subject = sprintf(
                Application_Constant_Global_Email::SUBJECT_HOTEL_AGODA_BOOKING_CONFIRMATION,
                $agodaOrder->{DbTable_Hotel::COL_HOTEL_NAME},
                $encode
            );

            foreach ($contactList as $contact) {
                $this->doSendMail(
                    $contact->{DbTable_Hotel_Contact::COL_HOTEL_CONTACT_EMAIL},
                    $contact->{DbTable_Hotel_Contact::COL_HOTEL_CONTACT_FULLNAME},
                    $subject,
                    $body
                );
            }
        }
    }

    /**
     * calculate  price for customer
     * @param Zend_Db_Table_Row_Abstract $agodaOrder
     */
    private function calculatePriceForCustomer($agodaOrder)
    {
        if ($agodaOrder) {
            $id = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_ID};
            $roomList = Model_HotelAgodaOrderRoom::getInstance()->getByFkOrder($id);
            $extraObjectList = Model_HotelAgodaOrderExtra::getInstance()->getByFkOrder($id);

            $startDate = new DateTime($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_START_DATE});
            $endDate = new DateTime($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_END_DATE});
            $interval = $endDate->diff($startDate);
            $numberDay = $interval->format('%a');
            $totalPrice = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_PAID_PRICE};

            $totalObjectFee = $numberDay * $this->_helper->calculateArrayByKey(
                    $extraObjectList->toArray(),
                    Application_Constant_Module_Default_HotelAgodaOrder::TOTAL_PAID_PRICE
                );

            $total = $totalPrice +  $totalObjectFee;
            $discount =  $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_DISCOUNT_TYPE} == Application_Constant_Db_Hotel_Agoda_Order::DISCOUNT_TYPE_MONEY ? intval($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_DISCOUNT}) : $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_DISCOUNT} * $total /100;

            if($discount > 0){
                if($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_CUSTOMER_DISCOUNT_TYPE} == Application_Constant_Db_Hotel_Agoda_Order::DISCOUNT_TYPE_PERCENT)
                    $discount = round($discount, -3, PHP_ROUND_HALF_UP);
            }

            $totalPayment  = $total - $discount;

            $this->view->assign('discountValue', $discount);
            $this->view->assign('totalPayment', $totalPayment);
            $this->view->assign('total', $total);
            $this->view->assign('totalPrice', $totalPrice);
            $this->view->assign('totalObjectFee', $totalObjectFee);
            $this->view->assign('numberDay', $numberDay);
            $this->view->assign('roomList', $roomList);
            $this->view->assign('extraObjectList', $extraObjectList);
        }
    }

    /**
     * calculate  price for hotel
     * @param Zend_Db_Table_Row_Abstract $agodaOrder
     */
    private function calculatePriceForHotel($agodaOrder)
    {
        if ($agodaOrder) {
            $id = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_ID};
            $roomList = Model_HotelAgodaOrderRoom::getInstance()->getByFkOrder($id);
            $extraObjectList = Model_HotelAgodaOrderExtra::getInstance()->getByFkOrder($id);

            $startDate = new DateTime($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_START_DATE});
            $endDate = new DateTime($agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_END_DATE});
            $interval = $endDate->diff($startDate);

            $numberDay = $interval->format('%a');
            $totalPrice = $agodaOrder->{DbTable_Hotel_Agoda_Order::COL_HOTEL_AGODA_ORDER_UNIT_PRICE};


            $totalObjectFee = $numberDay * $this->_helper->calculateArrayByKey(
                    $extraObjectList->toArray(),
                    Application_Constant_Module_Default_HotelAgodaOrder::TOTAL_PAID_PRICE
                );

            $total = $totalPrice + $totalObjectFee;
            $this->view->assign('total', $total);
            $this->view->assign('numberDay', $numberDay);
            $this->view->assign('roomList', $roomList);
            $this->view->assign('extraObjectList', $extraObjectList);
        }
    }

    /**
     * process order paid (calculate discount for customer)
     * @param int $customerId
     * @param int $orderId
     */
    public function processOrderPaid($customerId, $orderId){
        $encode = Model_HotelAgodaOrder::getInstance()->encode($orderId);
        $customer = Model_Customer::getInstance()->getById($customerId);

        if ($customer && $customer->{DbTable_Customer::COL_CUSTOMER_DISCOUNT_FLAG}) {
            $customerTransaction = Model_CustomerTransaction::getInstance()->searchByOrder($orderId, Application_Constant_Db_Customer_Transaction_Type::BOOKING_HOTEL_ORDER);
            if (!$customerTransaction) {
                $total = Model_HotelAgodaOrder::getInstance()->totalPaymentPrice($orderId);
                $markValue = round($customer->{DbTable_Customer::COL_CUSTOMER_DISCOUNT_VALUE} * $total / 100, 0);
                $reason = sprintf(
                    Application_Constant_Module_Default_HotelAgodaOrder::CUSTOMER_TRANSACTION_NOTE_PAID,
                    $encode
                );
                Model_Customer::getInstance()->updateMark($customerId, $markValue, $reason, Application_Constant_Db_Customer_Transaction_Type::BOOKING_HOTEL_ORDER, $orderId);
            }
        }
    }

    /**
     * process notify banking 123pay for hotel (123pay)
     * @param int $ticketId
     * @param int $transactionStatus
     * @return int
     */
    protected function processNotifyBankingHotel($ticketId, $transactionStatus)
    {
        $returnCode = 1;
        $orderData = Model_HotelAgodaOrder::getInstance()->getFullDetail($ticketId);
        if ($orderData) {
            if ($transactionStatus == 1) {
                $status = Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_SUCCESS_123PAY;

            } else {
                $status = Application_Constant_Db_Config_Hotel_Order_Status::TRANSACTION_FAILED_123PAY;
            }
            $message = Model_HotelAgodaOrder::getInstance()->updateStatus(
                $ticketId,
                $status
            );
            if ($message) {
                $returnCode = -3;
            }
        } else {
            $returnCode = -3;
        }
        return $returnCode;
    }

    /**
     * Process notify banking 123pay for car
     * @param int $ticketId
     * @param int $transactionStatus
     * @return int
     */
    protected function processNotifyBankingCar($ticketId, $transactionStatus)
    {
        $returnCode = 1;
        $orderData = Model_CarOrder::getInstance()->getById($ticketId);
        if ($orderData) {
            if ($transactionStatus == 1) {
                $status = Application_Constant_Db_Config_Car_Status::SUCCESS_123_PAY;
            } else {
                $status = Application_Constant_Db_Config_Car_Status::FAILED_123_PAY;
            }
            $message = Model_CarOrder::getInstance()->updateStatus($ticketId, $status);
            if ($message) {
                $returnCode = -3;
            }
        } else {
            $returnCode = -3;
        }
        return $returnCode;
    }

}