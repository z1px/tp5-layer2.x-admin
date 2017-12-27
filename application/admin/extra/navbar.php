<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/21
 * Time: 23:47
 */

// 左侧菜单
use think\Url;

/**
 * ID命名规则说明
 * ID分为五位数
 * 第一位表示一级菜单ID
 * 第二和第三位表示二级菜单ID
 * 第四和第五位表示三级菜单ID
 */
return [
    1=>[
        [
            "id" => "10100",
            "title" => "表格与表单",
            "icon" => "fa-ellipsis-v",
            "spread" => true,
            "children" => [
               [
                    "id" => "10101",
                    "title" => "报表",
                    "icon" => "fa-bar-chart",
                    "url" =>  Url::build('admin/Index/echarts')
                ],
            ]
        ],
    ],
    2=>[
        [
            "id" => "20100",
            "title" => "管理员管理",
            "icon" => "fa-user",
            "spread" => true,
            "children" => [
                [
                    "id" => "20101",
                    "title" => "管理员列表",
                    "icon" => "fa-users",
                    "url" => Url::build('admin/Account/table')
                ]
            ]
        ],
        [
            "id" => "20200",
            "title" => "日志管理",
            "icon" => "fa-file-text",
            "spread" => true,
            "children" => [
                [
                    "id" => "20201",
                    "title" => "登录日志",
                    "icon" => "fa-eraser",
                    "url" => Url::build('admin/Account/loginLog')
                ],
                [
                    "id" => "20202",
                    "title" => "行为日志",
                    "icon" => "&#xe60e;",
                    "url" => Url::build('admin/Account/behaviorLog')
                ]
            ]
        ],
        [
            "id" => "20300",
            "title" => "权限管理",
            "icon" => "fa-file-text",
            "spread" => true,
            "children" => [
                [
                    "id" => "20301",
                    "title" => "用户组",
                    "icon" => "fa-eraser",
                    "url" => Url::build('admin/AuthGroup/table')
                ],
                [
                    "id" => "20302",
                    "title" => "权限规则",
                    "icon" => "&#xe60e;",
                    "url" => Url::build('admin/AuthRule/table')
                ]
            ]
        ],
    ],
    3=>[
        [
            "id" => "30100",
            "title" => "常用地址",
            "icon" => "fa-book",
            "spread" => true,
            "children" => [
                [
                    "id" => "30101",
                    "title" => "Font图标",
                    "icon" => "fa-flag",
                    "url" => 'http://fontawesome.dashgame.com'
                ],
                [
                    "id" => "30102",
                    "title" => "LayUI文档",
                    "icon" => "&#xe62e;",
                    "url" => 'http://www.layui.com/doc/'
                ],
                [
                    "id" => "30103",
                    "title" => "ThinkPHP5文档",
                    "icon" => "fa-file-text-o",
                    "url" => 'https://www.kancloud.cn/manual/thinkphp5/118003'
                ],
            ]
        ],
    ],
    4=>[
        [
            "id" => "40100",
            "title" => "测试方法",
            "icon" => "fa-tags",
            "spread" => true,
            "children" => [
                [
                    "id" => "40101",
                    "title" => "redis测试",
                    "icon" => "fa-leaf",
                    "url" =>  Url::build('admin/Test/index')
                ],
            ]
        ],
    ],
];