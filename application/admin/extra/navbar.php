<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/21
 * Time: 23:47
 */

// 左侧菜单
use think\Url;

return [
    1=>[
        [
            "id" => "101",
            "title" => "表格与表单",
            "icon" => "fa-cubes",
            "spread" => true,
            "children" => [
               [
                    "id" => "104",
                    "title" => "报表",
                    "icon" => "&#xe63c;",
                    "url" =>  Url::build('admin/Index/echarts')
                ],
            ]
        ],
    ],
    2=>[
        [
            "id" => "201",
            "title" => "管理员",
            "icon" => "fa-cubes",
            "spread" => true,
            "children" => [
                [
                    "id" => "202",
                    "title" => "管理员列表",
                    "icon" => "&#xe6c6;",
                    "url" => Url::build('admin/Account/table')
                ],
                [
                    "id" => "203",
                    "title" => "登录日志",
                    "icon" => "&#xe6c6;",
                    "url" => Url::build('admin/Account/loginLog')
                ],
                [
                    "id" => "204",
                    "title" => "行为日志",
                    "icon" => "&#xe6c6;",
                    "url" => Url::build('admin/Account/behaviorLog')
                ]
            ]
        ],
    ],
];