<?php
class Cli_ExportController extends Application_Controller_Cli
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;

    public function init()
    {
        $this->_db = Zend_Registry::get('db_master');
    }

    /**
     * Usage: php cli.php export
     */
    public function indexAction()
    {
        $sRootPath   = str_replace('\\','/',realpath(dirname(basename(__FILE__)))) . '/upload/export/';
        $arrData     = Model_Export::getInstance()->getDataExport();
        $arrData     = $arrData->toArray();
        foreach($arrData as $rRow){
            $arrParam  = array(DbTable_Export::COL_FK_EXPORT_STATUS=>Application_Constant_Db_Export_Status::IN_PROCESS);
            Model_Export::getInstance()->updatedata($arrParam,$rRow[DbTable_Export::COL_EXPORT_ID]);
            try {
                $arrCheck = $this->_db->fetchAll($rRow[DbTable_Export::COL_EXPORT_QUERY]);
                if ($arrCheck) {
                    $arrData = array();
                    foreach ($arrCheck as $rRows) {
                        $arrData[] = $rRows;
                    }
                    $sFileName = 'Export_' . $rRow[DbTable_Export::COL_EXPORT_ID] . '_' . date('YmdHis') . '.xls';
                    $this->generateExcelResponse($arrData, $sFileName, true, $sRootPath . $sFileName);
                    $arrParam = array(DbTable_Export::COL_FK_EXPORT_STATUS => Application_Constant_Db_Export_Status::PROCESS_DONE, DbTable_Export::COL_EXPORT_SAVE_PATH => '/data/export/' . $sFileName);
                    Model_Export::getInstance()->updatedata($arrParam,$rRow[DbTable_Export::COL_EXPORT_ID]);
                } else {
                    $arrPram = array(DbTable_Export::COL_FK_EXPORT_STATUS=> Application_Constant_Db_Export_Status::PROCESS_DONE);
                    Model_Export::getInstance()->updatedata($arrPram,$rRow[DbTable_Export::COL_EXPORT_ID]);
                }
            } catch(exception $ex){
                $arrParam = array(DbTable_Export::COL_FK_EXPORT_STATUS => Application_Constant_Db_Export_Status::PROCESS_FAIL, DbTable_Export::COL_EXPORT_EXECUTION_RESPONSE => $ex);
                Model_Export::getInstance()->updatedata($arrParam,$rRow[DbTable_Export::COL_EXPORT_ID]);
            }
        }
    }
}