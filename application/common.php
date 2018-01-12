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