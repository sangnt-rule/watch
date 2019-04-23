<?php
/**
 * Created by PhpStorm.
 * User: phong
 * Date: 16/12/2016
 * Time: 15:40
 */
class View_Helper_Thumb extends Zend_View_Helper_Abstract
{
    public function thumb($filePath, $width)
    {
        $result = null;
        if ($filePath) {
            $uploadSymbol = 'upload';
            if (strstr($filePath, $uploadSymbol)) {
                $info = explode($uploadSymbol, $filePath);
                $filePath = $info[1];
            }

            $pathUpload = SYS_PATH . '/public/upload';
            $filePath = rawurldecode($pathUpload . $filePath);
            $filePathInfo = explode('.', $filePath);
            $indexFileName = count($filePathInfo)-2;
            $filePathInfo[$indexFileName] = sprintf('%s_%d', $filePathInfo[$indexFileName], $width);
            $thumbPath = implode('.', $filePathInfo);

            if (!file_exists($thumbPath) && file_exists($filePath)) {
                Application_Function_Image::make_thumb($filePath, $thumbPath, $width);
            }
            if (file_exists($thumbPath)) {
                $result = $thumbPath;
            } else {
                $result = $filePath;
            }
            $result = str_replace($pathUpload, HOST_UPLOAD, $result);
        }
        if ($result) {
            $resultInfo = explode('/', $result);
            if ($resultInfo) {
                $params = array();
                foreach ($resultInfo as $param) {
                    array_push($params, rawurlencode($param));
                }
                $result = implode('/', $params);
            }
        }
        return $result;
    }
}