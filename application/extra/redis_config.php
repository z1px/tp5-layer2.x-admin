<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27
 * Time: 14:38
 */

// redis数据库连接配置文件
return [
    'host'         => '127.0.0.1', // redis主机
    'port'         => 6379, // redis端口
    'password'     => '', // 密码
    'select'       => 1, // 操作库
    'timeout'      => 180, // 超时时间(秒)
    'persistent'   => true, // 是否长连接
];