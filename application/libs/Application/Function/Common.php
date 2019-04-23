<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/23/15
 * Time: 10:25 PM
 */
class Application_Function_Common
{
    /**
     * Swap elements
     * @param mixed $a
     * @param mixed $b
     */
    static function swap(&$a, &$b)
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
        unset($temp);
    }

    /**
     * Retrieve back url
     * @return string
     */
    static function referredUrl()
    {
        return isset($_SERVER['HTTP_REFERER']) ?  $_SERVER['HTTP_REFERER'] : '/';
    }

    /**
     * Get full current Url
     * @param array $excludeData
     * @return string
     */
    static function fullCurrentUrl($excludeData = array())
    {
        $url = sprintf(
            'http://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        $urlInfo = explode('?', $url);
        $params = isset($urlInfo[1]) ? $urlInfo[1] : null;
        $needed = array();
        if ($params) {
            $paramsInfo = explode('&', $params);
            if ($paramsInfo) {
                foreach ($paramsInfo as $info) {
                    $infoDetail = explode('=', $info);
                    if (!$excludeData || ($excludeData && !in_array($infoDetail[0], $excludeData))) {
                        array_push($needed, $info);
                    }
                }
            }
        }
        $result = $urlInfo[0];
        if ($needed) {
            $result = $result . '?' . implode('&', $needed);
        }
        return $result;
    }

    /**
     * Get full Url without paramss
     * @return mixed
     */
    static function fullCurrentUrlNoParam()
    {
        $url = sprintf(
            'http://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        );
        $urlInfo = explode('?', $url);
        $result = current($urlInfo);
        $result = str_replace('index.php', '', $result);
        return $result;
    }

    /**
     * Get current URL
     * @return string
     */
    static function currentUrl()
    {
        return "http://$_SERVER[HTTP_HOST]";
    }

    /**
     * Build domain name
     * @param null|string $subName
     * @return string
     */
    static function buildDomain($subName=null)
    {
        $hostName = $_SERVER['HTTP_HOST'];
        $hostInfo = explode('.', $hostName);
        $n = count($hostInfo);
        $domain = $hostInfo[$n-2] . '.' . $hostInfo[$n-1];
        if ($subName) {
            $domain = $subName . '.' . $domain;
        }
        return $domain;
    }

    /**
     * Build Url with param options
     * @param array $optionsUrl
     * @return string
     */
    static function buildUrl($optionsUrl=array())
    {
        $uri = $_SERVER['REQUEST_URI'];
        if ($uri) {
            $uriInfo = explode('?', $uri);
            $request = isset($uriInfo[1]) ? $uriInfo[1] : null;
            if ($request) {
                $requestInfo = explode('&', $request);
                $requestArr = array();
                if ($requestInfo) {
                    $keyOptionsUrl = $optionsUrl ? array_keys($optionsUrl) : array();
                    foreach ($requestInfo as $query) {
                        $queryInfo = explode('=', $query);
                        if (!in_array($queryInfo[0], $keyOptionsUrl)) {
                            array_push($requestArr, $query);
                        }
                    }
                }
                $request = implode('&', $requestArr);
            }
            $uriInfo[1] = $request;
            $uri = implode('?', $uriInfo);
        }
        if ($optionsUrl) {
            foreach ($optionsUrl as $params => $value) {
                $uri .= sprintf('&%s=%s', $params, $value);
            }
        }
        return self::currentUrl() . $uri;
    }

    /**
     * Convert month to string
     * @param int $month
     * @return mixed
     */
    static function convertMonth($month)
    {
        $data = array('Tháng Giêng', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai');
        return $data[$month-1];
    }

    /**
     * Remove the end of route in route.ini
     * @param string $route
     * @return mixed
     */
    static function formatRouteConfig($route)
    {
        return str_replace('[/]?', '', $route);
    }

    /**
     * Collect image source from FCK content
     * @param string $content
     * @return array
     */
    static function collectImageFromFckString($content)
    {
        $result = array();
        if ($content) {
            $content = trim($content);
            $dom = new DOMDocument('1.0','UTF-8');
            libxml_use_internal_errors(true);
            $dom->loadHTML($content);
            libxml_clear_errors();
            $imageData = $dom->getElementsByTagName('img');

            if ($imageData) {
                foreach ($imageData as $element) {
                    array_push($result, $element->getAttribute('src'));
                }
            }

            $inputData = $dom->getElementsByTagName('input');
            if ($inputData) {
                foreach ($inputData as $element) {
                    $type = $element->getAttribute('type');
                    if ($type == 'image') {
                        $src = $element->getAttribute('src');
                        if ($src) {
                            array_push($result, $src);
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param $command
     * @return string
     */
    static function buildCommandScriptInBackground($command)
    {
        $result = sprintf('bash -c "exec nohup setsid %s > /dev/null 2>&1 &"', $command);
        return $result;
    }
}