<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('redirect_go')){
    /**
     * @brief 페이지 리다이렉트
     * @param $msg
     * @param $url
     */
    function redirect_go($msg,$url)
    {
        echo '<script>window.alert("'.$msg.'");
        window.location.href="'.$url.'";</script>';
    }
}

if ( ! function_exists('dump')){
    /**
     * @brief 덤프 출력
     * @param $obj
     */
    function dump($obj)
    {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
    }
}

if ( ! function_exists('copy_and_unset')){
    /**
     * @param $arr
     * @param $obj
     * @return null or string
     */
    function copy_and_unset($arr, $obj)
    {
        $result = null;
        if(isset($arr[$obj]))
        {
            $result = $arr[$obj];
            unset($arr[$obj]);
        }

        return $result;
    }
}