<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 7/11/16
 * Time: 4:42 PM
 */
class Application_Function_Excel
{
    /**
     * Transform excel data to array
     * @param string $inputFileName
     * @param array $response
     * @return null|string
     */
    static function transformToArray($inputFileName, &$response)
    {
        $message = null;
        $objPHPExcel = null;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        if (!$message) {
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $arrHeader = array();
            foreach ($objWorksheet->getRowIterator() as $k => $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                if ($k == 1) {
                    foreach ($cellIterator as $cell) {
                        array_push($arrHeader, trim($cell->getFormattedValue()));
                    }
                } else {
                    $i = 0;
                    $arrTemp = array();
                    foreach ($cellIterator as $cell) {
                        if ( isset($arrHeader[$i]) ) {
                            $arrTemp[$arrHeader[$i]]	= trim($cell->getFormattedValue());
                        }
                        $i++;
                    }
                    if (Application_Function_Array::isValidatedRow($arrTemp)) {
                        array_push($response, $arrTemp);
                    }
                }
            }
        }
        return $message;
    }
}