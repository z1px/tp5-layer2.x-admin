<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 检测手机格式
 * @param $phone
 * @return bool
 */
function check_phone($phone) {
    preg_match('/^1[34578][0-9]{9}$/', $phone, $matches);
    if (empty($matches))
        return false;
    else
        return true;
}

/**
 * 检测邮箱格式
 * @param $email
 * @return bool
 */
function check_email($email) {
    preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i', $email, $matches);
    if (empty($matches))
        return false;
    else
        return true;
}

/**
 * 通过新浪接口获取IP城市
 * @param $ip
 * @return bool|string
 */
function get_ip_area($ip){
    if(empty($ip)) return false;
    $url='http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip;
    $ch=curl_init($url);
    curl_setopt($ch,CURLOPT_ENCODING,'utf8');
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//获取数据返回
    $location=curl_exec($ch);
    curl_close($ch);
    $location=json_decode($location,true);
    $result="";
    if(!empty($location["province"])) $result.=" ".$location["province"];
    if(!empty($location["city"])) $result.=" ".$location["city"];
    if(!empty($location["district"])) $result.=" ".$location["district"];
    if(!empty($location["isp"])) $result.=" ".$location["isp"];
    return trim($result);
}