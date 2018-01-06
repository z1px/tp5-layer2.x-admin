<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__domain__'=>[//配置二级域名
        'py'      => 'admin',
        // 泛域名规则建议在最后定义
//        '*'         => 'index',
    ],
    'login'=>"admin/Index/login",
    'logout'=>"admin/Index/logout",
    'main'=>"admin/Index/main",
];
