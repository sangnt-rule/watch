<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/22/15
 * Time: 9:22 AM
 */
class Application_Controller extends Zend_Controller_Action
{
    /**
     * @var Zend_Translate
     */
    protected $translate;

    /**
     * @var STDClass
     */
    protected $session;

    public function init()
    {
        $this->session = Application_Session_Default::getInstance()->load();
    }

    public function preDispatch()
    {
        $this->view->assign('translate', $this->getTranslate());
    }

    public function postDispatch()
    {
        $this->view->assign('currentLocale', $this->getCurrentLocale());
    }

    /**
     * Get translate object
     * @return Zend_Translate
     */
    protected function getTranslate()
    {
        if (is_null($this->translate)) {
            $this->translate = new Zend_Translate(
                'tmx',
                SYS_PATH . '/data/locales/',
                $this->getCurrentLocale()
            );
        }
        return $this->translate;
    }

    /**
     * Get current locale
     * @return string
     */
    protected function getCurrentLocale()
    {
        $session = $this->getSession();
        return isset($session->locale) ? $session->locale : 'vi';
    }

    /**
     * Set current locale
     * @param string $code
     */
    protected function setCurrentLocale($code)
    {
        $this->getSession()->locale = trim($code);
        $this->saveSession();
    }

    /**
     * Get value translation by key
     * @param string $key
     * @return string
     */
    protected function getTranslateValue($key)
    {
        return $this->getTranslate()->_($key);
    }

    protected function getSession()
    {
        if (is_null($this->session) || !is_object($this->session)) {
            $this->session = new STDClass();
            $this->session->locale = Application_Constant_Global::LOCALE_VI;
            $this->session->captcha = null;
            $this->session->adminInfo = null;
        }
        return $this->session;
    }

    /**
     * Save session information
     */
    protected function saveSession()
    {
        Application_Session_Default::getInstance()->save($this->session);
    }

    /**
     * Set session admin info
     * @param STDClass $adminInfo
     */
    protected function setSessionAdminInfo($adminInfo)
    {
        $this->getSession()->adminInfo = $adminInfo;
        $this->saveSession();
    }

    /**
     * Remove session admin info
     */
    protected function removeSessionAdminInfo()
    {
        $this->getSession()->adminInfo = null;
        $this->saveSession();
    }

    /**
     * Get config object
     * @return Zend_Config
     */
    protected function getConfig()
    {
        return Zend_Registry::get('config');
    }

    /**
     * Redirect method
     * @param string $url
     * @param array $option
     */
    protected function gotoUrl($url, $option=array())
    {
        $this->_redirect($url, $option);
        $this->_helper->redirector->gotoUrl($url);
    }

    /**
     * Auto load resource Css & Js
     * @param array $resourceArr
     * @param string $type
     */
    protected function autoLoadResource($resourceArr, $type='js')
    {
        $time = time();
        $base_path = SYS_PATH . '/public/statics/asset/' . $this->getRequest()->getModuleName() . '/';

        $resourceArr[] = sprintf(
            'autoload/%s/%s.%s?m=%s',
            $type,
            $this->getRequest()->getControllerName(),
            $type,
            $time
        );
        $resourceArr[] = sprintf(
            'autoload/%s/%s/%s.%s?m=%s',
            $type,
            $this->getRequest()->getControllerName(),
            $this->getRequest()->getActionName(),
            $type,
            $time
        );

        foreach ($resourceArr as $resource) {
            $resourceInfo = explode('?', $resource);
            $resourceFile = $resourceInfo[0];
            if (file_exists($base_path . $resourceFile)) {
                if ($type=='js') {
                    $this->view->headScript()->appendFile($this->generatePathStatic($resource));
                } else {
                    $this->view->headLink()->appendStylesheet($this->generatePathStatic($resource));
                }
            }
        }
    }

    /**
     * Generate static path
     * @param string $resource
     * @return string
     */
    protected function generatePathStatic($resource)
    {
        $path = '';
        /*
        switch (MODULE_NAME) {
            case 'mobile':
                $path = HOST_STATIC_MOBILE;
                break;
            case 'default':
                $path = HOST_STATIC_DEFAULT;
                break;
            default:
                break;
        }*/
        return $path . $resource;
    }

    /**
     * Disable layout & stop rendering
     */
    protected function noRender()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->noLayout();
    }

    /**
     * Disable layout
     */
    protected function noLayout()
    {
        $this->_helper->layout->disableLayout();
    }

    /**
     * Load gird data with pagination
     * @param Zend_Db_Select $select
     * @param int $limit
     */
    protected function loadGird($select, $limit=Application_Constant_Module_Admin::LIMIT)
    {
        $page = $this->getRequest()->getParam('page');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setDefaultItemCountPerPage($limit);

        $this->view->assign('pagination', $pagination);
    }

    /**
     * Transform excel data to array
     * @param string $fileId
     * @return array
     */
    protected function transformExcelToArray($fileId)
    {
        $file = isset($_FILES[$fileId]) ? $_FILES[$fileId] : null;
        $error_code = Application_Constant_Global_Excel::FAILED;
        $message = null;
        $data = array();
        if ($file) {
            $inputFileName = $file['tmp_name'];
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $error_code = Application_Constant_Global_Excel::SUCCESSFUL;
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
            if ($error_code==Application_Constant_Global_Excel::SUCCESSFUL) {
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                for ($row = 1; $row <= $highestRow; $row++) {
                    $data[$row] = array();
                    //  Read a row of data into an array
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                        NULL, TRUE, FALSE);
                    foreach($rowData[0] as $col=>$value) {
                        $data[$row][$col+1] = $value;
                    }
                }
            }
        }
        return array(
            Application_Constant_Global_Excel::KEY_ERROR => $error_code,
            Application_Constant_Global_Excel::KEY_MESSAGE => $message,
            Application_Constant_Global_Excel::KEY_DATA => $data
        );
    }

    /**
     * Return upload path
     * @return string
     */
    protected function getUploadPath()
    {
        return SYS_PATH . '/public/upload';
    }

    /**
     * Return uploads data path
     * @return string
     */
    protected function getUploadDataPath()
    {
        return SYS_PATH . '/data/uploads';
    }

    /**
     * Upload file and return new file name
     * @param string $component
     * @param string $elementName
     * @param boolean $onlyCopy
     * @return mixed|null
     */
    protected function uploadImage($component, $elementName, $onlyCopy = false)
    {
        $image = '';
        if (isset($_FILES[$elementName]) && $_FILES[$elementName]['name']) {
            $folder = $this->getUploadPath() . '/' .$component;
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' .date('Y');
            if (!is_dir($folder)) {
                mkdir($folder);
            }   
            $folder = $folder . '/' . date('m');
            if (!is_dir($folder)) {
                mkdir($folder);
            }
            $folder = $folder . '/' . date('d');
            if (!is_dir($folder)) {
                mkdir($folder);
            }

            $file = $_FILES[$elementName];
            $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName($file['name']));
            if ($onlyCopy) {
                $response = copy($file['tmp_name'], $imagePath);
            } else {
                $response = move_uploaded_file($file['tmp_name'], $imagePath);
            }
            if ($response) {
                $image = str_replace($this->getUploadPath(), '', $imagePath);
            }
            /*
            $adapter = new Zend_File_Transfer();
            $fileArr = $adapter->getFileInfo();
            $file = isset($fileArr[$elementName]) ? $fileArr[$elementName] : null;
            if ($file) {
                $imagePath = sprintf('%s/%s', $folder, $this->_helper->generateImageName($file['name']));
                $adapter->addFilter(
                    'Rename', $imagePath
                );
                $adapter->receive();
                $image = str_replace($this->getUploadPath(), '', $imagePath);
            }
            */
        }
        return $image;
    }

    /**
     * Get session Id
     * @return string
     */
    protected function getSessionId()
    {
        if (!Zend_Session::isStarted()) {
            Zend_Session::start();
        }
        return Zend_Session::getId();
    }

    protected function cleanUpSessionId(){
        Zend_Session::regenerateId();
    }

    /**
     * Do send email
     * @param string $email
     * @param string $fullName
     * @param string $subject
     * @param string $body
     */
    protected function doSendMail($email, $fullName, $subject, $body)
    {
        $config = $this->getConfig();
        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyHtml($body);
        $mail->setFrom(
            $config->smtp->config->username,
            'vedulich.vn Admin'
        );
        $mail->addTo($email, $fullName);
        $mail->setSubject(
            sprintf('Vedulich.vn %s', $subject)
        );
        $transport = new Zend_Mail_Transport_Smtp($config->smtp->host, $config->smtp->config->toArray());
        $mail->send($transport);
        return true;
    }

    /**
     * Send SMS
     * @param string $phone
     * @param string $message
     * @param int|string $requestId
     * @return mixed
     */
    protected function doSendSms($phone, $message, $requestId)
    {
        $config = Zend_Registry::get('config');
        $response = '';
        if ($config->env->name != 'dev') {
            $configSettingInfo = Model_ConfigSetting::getInstance()->getById(Application_Constant_Db_Config_Setting::SMS_PROVIDER);
            if ($configSettingInfo) {
                if ($configSettingInfo[DbTable_Config_Setting::COL_CONFIG_SETTING_VALUE] == Application_Constant_Global_SmsProvider::GOMOBI) {
                    $client = new Zend_Soap_Client(
                        'http://sms.gateway.gomobi.vn:7777/SMS_API_Outside/WS_Send_MT_Spam?WSDL',
                        array(
                            'soap_version' => SOAP_1_1,
                            'encoding' => 'UTF-8'
                        )
                    );

                    $request = new stdClass();
                    $request->Phone = $this->_helper->formatPhoneNumber($phone);
                    $request->WAPTitle = $config->sms->gomobi->WAPTitle;
                    $request->Message = trim($message);
                    $request->MsgType = intval($config->sms->gomobi->MsgType);
                    $request->SendingTime = '';
                    $request->PartnerID = intval($config->soap->id);
                    $request->RequestID = $requestId;
                    $request->TokenKey = md5($request->Phone . $request->WAPTitle . $request->Message . $request->MsgType . $request->SendingTime . $request->PartnerID . $request->RequestID . $config->soap->key);
                    $response = $client->Send_MT_Spam_V2($request);

                } elseif ($configSettingInfo[DbTable_Config_Setting::COL_CONFIG_SETTING_VALUE] == Application_Constant_Global_SmsProvider::VIETGUYS) {
                    $client = new Zend_Soap_Client(
                        'http://cloudsms.vietguys.biz:8088/webservices/sendsmsw.php?wsdl',
                        array(
                            'soap_version' => SOAP_1_1,
                            'encoding' => 'UTF-8'
                        )
                    );

                    $request = new stdClass();
                    $request->phone = $this->_helper->formatPhoneNumber($phone);
                    $request->passcode = $config->sms->vietguys->passcode;
                    $request->sms = trim($message);
                    $request->account = $config->sms->vietguys->account;
                    $request->password = '';
                    $request->contenttype = '';
                    $request->messagetype = '';
                    $request->messageid = '';
                    $request->transactionid = '';
                    $request->service_id = $config->sms->vietguys->service_id;
                    $request->json = '';
                    $response = $client->send($request);
                }
            }
        }
        return $response;
    }

    /**
     * Generate output excel file
     * @param array $data
     * @param string $fileName
     * @param string $filePath
     * @param boolean $heading
     */
    protected function generateExcelResponse($data, $fileName='excel', $heading=true, $filePath = 'php://output')
    {
        if ($data) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('AA-WMS');

            if ($heading) {
                $headings = array_keys(current($data));
                $rowNumber = 1;
                $col = 'A';
                foreach($headings as $heading) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
                    $col++;
                }
            }

            $rowNumber = 2;
            foreach ($data as $item) {
                $col = 'A';
                foreach ($item as $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col++.$rowNumber, $value);
                }
                $rowNumber++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header(
                sprintf('Content-Disposition: attachment;filename="%s.%s.xls"', $fileName, date('YmdHis'))
            );
            header('Cache-Control: max-age=0');
            $objWriter->save($filePath);
        }
    }

    /**
     * Generate output excel file multi sheet
     * @param array $sheetData
     * @param string $fileName
     * @param boolean $heading
     */
    protected function generateExcelResponseMultiSheet($sheetData, $fileName='excel', $heading=true)
    {
        if ($sheetData) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet();
            $objPHPExcel->removeSheetByIndex(0);
            foreach ($sheetData as $key => $data) {
                $objWorkSheet = $objPHPExcel->createSheet();
                $objWorkSheet->setTitle($key);
                if ($heading) {
                    $headings = array_keys(current($data));
                    $rowNumber = 1;
                    $col = 'A';
                    foreach ($headings as $heading) {
                        $objWorkSheet->setCellValue($col . $rowNumber, $heading);
                        $col++;
                    }
                }

                $rowNumber = 2;
                foreach ($data as $item) {
                    $col = 'A';
                    foreach ($item as $value) {
                        $objWorkSheet->setCellValue($col++ . $rowNumber, $value);
                    }
                    $rowNumber++;
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header(
                sprintf('Content-Disposition: attachment;filename="%s.%s.xls"', $fileName, date('YmdHis'))
            );
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
    }

    /**
     * Set cookie value
     * @param string $key
     * @param mixed $value
     */
    protected function setCookie($key, $value)
    {
        setcookie($key, $value, time()+(30*24*3600), '/', $_SERVER['HTTP_HOST']);
    }

    /**
     * Retrieve cookie value
     * @param string $key
     * @return mixed
     */
    protected function getCookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
     * Clean up cookie value
     * @param string $key
     */
    protected function cleanUpCookie($key)
    {
        unset($_COOKIE[$key]);
        setcookie($key, '', time()-3600, '/', $_SERVER['HTTP_HOST']);
    }

    protected function renderCaptcha($position=-1, $onlyUpperCase=false)
    {
        $config = Zend_Registry::get('config');
        $captchaCode = strtolower($this->_helper->randomString(4));
        $value = $position == -1 ? $captchaCode : $captchaCode[$position] ;
        if ($onlyUpperCase) {
            $value = strtoupper($value);
            $captchaCode = strtoupper($captchaCode);
        }
        $this->saveSessionCaptcha($value);
        Application_Function_Image::renderCaptcha($captchaCode, $config->data->font, $position, 190, 40);
    }

    /**
     * Set captcha to session
     * @param string $value
     */
    protected function saveSessionCaptcha($value)
    {
        $this->getSession()->captcha = trim($value);
        $this->saveSession();
    }

    /**
     * Validate captcha
     * @param string $input
     * @param boolean $textDecoration
     * @return bool
     */
    protected function validateSessionCaptcha($input, $textDecoration=true)
    {
        return $textDecoration ? ($input===$this->getSession()->captcha) : (strtolower($input)==strtolower($this->getSession()->captcha));
    }

    /**
     * Generate output pdf file
     * @param string $shtml content of html
     * @param string $sfilepath link save file
     * @return bool
     */
    protected function generatePdf($shtml, $sfilepath)
    {
        define('__DIR__' , SYS_PATH . '/library/tcpdf/');
        include SYS_PATH . '/library/tcpdf/tcpdf.php';
        try {
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('QC VIETNAM');
            $pdf->SetTitle('AAA LOGISTICS');
            $pdf->SetSubject('AAA LOGISTICS');
            $pdf->SetKeywords('AAA LOGISTICS');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'AAA LOGISTICS', PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // add a page
            $pdf->AddPage();
            // output the HTML content
            $pdf->writeHTML($shtml, true, 0, true, 0);
            // reset pointer to the last page
            $pdf->lastPage();
            //Close and output PDF document
            $pdf->Output($sfilepath, 'F');
            return true;
        } catch(Exception $ex){
            return false;
        }
    }

    /**
     * Get back Url
     * @return string
     */
    public function getBackUrl()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    /**
     * Generate javascript for window parent
     * @param string $functionName
     * @param array $data
     * @return string
     */
    protected function callScriptParent($functionName, $data=array())
    {
        $functionName = trim($functionName);
        $params = '';
        if ($data) {
            $params = sprintf('"%s"', implode('","', $data));
        }

        return  '<script>parent.'. $functionName .'('. $params .')</script>';
    }

}