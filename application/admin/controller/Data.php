<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 16:43
 */

namespace app\admin\controller;


use think\Request;
use think\Url;

class Data extends Common {

    protected function _before() {

    }

    public function onelevel(){
        $this->result = [
            [
                "title"=>"控制台",
                "icon"=>"fa-circle-o",
                "id"=>"1"
            ], [
                "title"=>"商品管理",
                "icon"=>"&#xe658;",
                "id"=>"2"
            ]
        ];
        return $this->_result();
    }

    public function navbar(){
        switch ($this->request->param("id",0)) {
            case 1:
                $this->result = [
                    [
                        "id" => "101",
                        "title" => "表格与表单",
                        "icon" => "fa-cubes",
                        "spread" => true,
                        "children" => [
                            [
                                "id" => "102",
                                "title" => "表格",
                                "icon" => "&#xe6c6;",
                                "url" => Url::build('admin/Index/table')
                            ],
                            [
                                "id" => "103",
                                "title" => "表单",
                                "icon" => "&#xe63c;",
                                "url" =>  Url::build('admin/Index/form')
                            ],
                            [
                                "id" => "104",
                                "title" => "报表",
                                "icon" => "&#xe63c;",
                                "url" =>  Url::build('admin/Index/echarts')
                            ],
                        ]
                    ],
                    [
                        "id" => "1",
                        "title" => "基本元素",
                        "icon" => "fa-cubes",
                        "spread" => true,
                        "children" => [
                            [
                                "id" => "7",
                                "title" => "表格",
                                "icon" => "&#xe6c6;",
                                "url" => "test.html"
                            ],
                            [
                                "id" => "8",
                                "title" => "表单",
                                "icon" => "&#xe63c;",
                                "url" => "form.html"
                            ],
                            [
                                "id" => "9",
                                "title" => "导航栏",
                                "icon" => "&#xe628;",
                                "url" => "nav.html"
                            ],
                            [
                                "id" => "10",
                                "title" => "列表四",
                                "icon" => "&#xe614;",
                                "url" => "list4.html"
                            ],
                            [
                                "id" => "11",
                                "title" => "百度一下",
                                "icon" => "&#xe658;",
                                "url" => "https://www.baidu.com",
                            ]
                        ]
                    ],
                    [
                        "id" => "2",
                        "title" => "组件",
                        "icon" => "fa-cogs",
                        "spread" => false,
                        "children" => [
                            [
                                "id" => "12",
                                "title" => "Navbar",
                                "icon" => "fa-table",
                                "url" => "navbar.html"
                            ],
                            [
                                "id" => "13",
                                "title" => "Tab",
                                "icon" => "&#xe658;",
                                "url" => "tab.html"
                            ],
                            [
                                "id" => "14",
                                "title" => "app.js主入口",
                                "icon" => "&#xe658;",
                                "url" => "app.html"
                            ]
                        ]
                    ],
                    [
                        "id" => "4",
                        "title" => "地址本",
                        "icon" => "fa-address-book",
                        "url" => "",
                        "spread" => false,
                        "children" => [
                            [
                                "id" => "17",
                                "title" => "Github",
                                "icon" => "fa-github",
                                "url" => "https://www.github.com/"
                            ],
                            [
                                "id" => "18",
                                "title" => "QQ",
                                "icon" => "fa-qq",
                                "url" => "http://www.qq.com/"
                            ],
                            [
                                "id" => "19",
                                "title" => "Fly社区",
                                "icon" => "&#xe609;",
                                "url" => "http://fly.layui.com/"
                            ],
                            [
                                "id" => "20",
                                "title" => "新浪微博",
                                "icon" => "fa-weibo",
                                "url" => "http://weibo.com/"
                            ]
                        ]
                    ],
                    [
                        "id" => "5",
                        "title" => "这是一级导航",
                        "icon" => "fa-stop-circle",
                        "url" => "https://www.baidu.com",
                        "spread" => false
                    ],
                    [
                        "id" => "6",
                        "title" => "其他",
                        "icon" => "fa-stop-circle",
                        "url" => "#",
                        "spread" => false,
                        "children" => [
                            [
                                "id" => "21",
                                "title" => "子窗体中打开选项卡",
                                "icon" => "fa-github",
                                "url" => "cop.html"
                            ]
                        ]
                    ]
                ];
                break;
            case 2:
                $this->result = [
                    [
                        "id"=>"2",
                        "title"=>"组件",
                        "icon"=>"fa-cogs",
                        "spread"=>false,
                        "children"=>[
                            [
                                "id"=>"12",
                                "title"=>"Navbar",
                                "icon"=>"fa-table",
                                "url"=>"navbar.html"
                            ], [
                                "id"=>"13",
                                "title"=>"Tab",
                                "icon"=>"&#xe658;",
                                "url"=>"tab.html"
                            ], [
                                "id"=>"14",
                                "title"=>"app.js主入口",
                                "icon"=>"&#xe658;",
                                "url"=>"app.html"
                            ]
                        ]
                    ], [
                        "id"=>"1",
                        "title"=>"基本元素",
                        "icon"=>"fa-cubes",
                        "spread"=>true,
                        "children"=>[
                            [
                                "id"=>"7",
                                "title"=>"表格",
                                "icon"=>"&#xe6c6;",
                                "url"=>"test.html"
                            ], [
                                "id"=>"8",
                                "title"=>"表单",
                                "icon"=>"&#xe63c;",
                                "url"=>"form.html"
                            ], [
                                "id"=>"9",
                                "title"=>"导航栏",
                                "icon"=>"&#xe628;",
                                "url"=>"nav.html"
                            ], [
                                "id"=>"10",
                                "title"=>"列表四",
                                "icon"=>"&#xe614;",
                                "url"=>"list4.html"
                            ], [
                                "id"=>"11",
                                "title"=>"百度一下",
                                "icon"=>"&#xe658;",
                                "url"=>"https://www.baidu.com"
                            ]
                        ]
                    ], [
                        "id"=>"4",
                        "title"=>"地址本",
                        "icon"=>"fa-address-book",
                        "url"=>"",
                        "spread"=>false,
                        "children"=>[
                            [
                                "id"=>"17",
                                "title"=>"Github",
                                "icon"=>"fa-github",
                                "url"=>"https://www.github.com/"
                            ], [
                                "id"=>"18",
                                "title"=>"QQ",
                                "icon"=>"fa-qq",
                                "url"=>"http://www.qq.com/"
                            ], [
                                "id"=>"19",
                                "title"=>"Fly社区",
                                "icon"=>"&#xe609;",
                                "url"=>"http://fly.layui.com/"
                            ], [
                                "id"=>"20",
                                "title"=>"新浪微博",
                                "icon"=>"fa-weibo",
                                "url"=>"http://weibo.com/"
                            ]
                        ]
                    ], [
                        "id"=>"5",
                        "title"=>"这是一级导航",
                        "icon"=>"fa-stop-circle",
                        "url"=>"https://www.baidu.com",
                        "spread"=>false
                    ], [
                        "id"=>"6",
                        "title"=>"其他",
                        "icon"=>"fa-stop-circle",
                        "url"=>"#",
                        "spread"=>false,
                        "children"=>[
                            [
                                "id"=>"21",
                                "title"=>"子窗体中打开选项卡",
                                "icon"=>"fa-github",
                                "url"=>"cop.html"
                            ]
                        ]
                    ]
                ];
                break;
            default:
                $this->result = [];
        }
        return $this->_result();
    }

    public function table(){
        $this->result = [
            "code"=>0,
            "msg"=>"",
            "count"=>1000,
            "data"=>[
                [
                    "id"=>10000,
                    "username"=>"user-0",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-0",
                    "experience"=>499,
                    "logins"=>138,
                    "wealth"=>62007298,
                    "classify"=>0,
                    "score"=>"11.47"
                ],
                [
                    "id"=>10001,
                    "username"=>"user-1",
                    "sex"=>1,
                    "city"=>2,
                    "sign"=>"签名-1",
                    "experience"=>960,
                    "logins"=>24,
                    "wealth"=>71513669,
                    "classify"=>1,
                    "score"=>"28.34"
                ],
                [
                    "id"=>10002,
                    "username"=>"user-2",
                    "sex"=>0,
                    "city"=>0,
                    "sign"=>"签名-2",
                    "experience"=>911,
                    "logins"=>49,
                    "wealth"=>12867792,
                    "classify"=>2,
                    "score"=>"25.85"
                ],
                [
                    "id"=>10003,
                    "username"=>"user-3",
                    "sex"=>1,
                    "city"=>2,
                    "sign"=>"签名-3",
                    "experience"=>112,
                    "logins"=>32,
                    "wealth"=>6736741,
                    "classify"=>2,
                    "score"=>"95.36"
                ],
                [
                    "id"=>10004,
                    "username"=>"user-4",
                    "sex"=>0,
                    "city"=>3,
                    "sign"=>"签名-4",
                    "experience"=>695,
                    "logins"=>159,
                    "wealth"=>70617394,
                    "classify"=>4,
                    "score"=>"42.48"
                ],
                [
                    "id"=>10005,
                    "username"=>"user-5",
                    "sex"=>0,
                    "city"=>3,
                    "sign"=>"签名-5",
                    "experience"=>407,
                    "logins"=>88,
                    "wealth"=>98900963,
                    "classify"=>0,
                    "score"=>"77.31"
                ],
                [
                    "id"=>10006,
                    "username"=>"user-6",
                    "sex"=>1,
                    "city"=>1,
                    "sign"=>"签名-6",
                    "experience"=>230,
                    "logins"=>73,
                    "wealth"=>4063839,
                    "classify"=>4,
                    "score"=>"72.66"
                ],
                [
                    "id"=>10007,
                    "username"=>"user-7",
                    "sex"=>0,
                    "city"=>2,
                    "sign"=>"签名-7",
                    "experience"=>1042,
                    "logins"=>198,
                    "wealth"=>9805772,
                    "classify"=>0,
                    "score"=>"2.88"
                ],
                [
                    "id"=>10008,
                    "username"=>"user-8",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-8",
                    "experience"=>942,
                    "logins"=>147,
                    "wealth"=>96230862,
                    "classify"=>2,
                    "score"=>"79.54"
                ],
                [
                    "id"=>10009,
                    "username"=>"user-9",
                    "sex"=>1,
                    "city"=>0,
                    "sign"=>"签名-9",
                    "experience"=>1014,
                    "logins"=>104,
                    "wealth"=>55726955,
                    "classify"=>4,
                    "score"=>"64.30"
                ],
                [
                    "id"=>10010,
                    "username"=>"user-10",
                    "sex"=>0,
                    "city"=>2,
                    "sign"=>"签名-10",
                    "experience"=>700,
                    "logins"=>66,
                    "wealth"=>93316089,
                    "classify"=>4,
                    "score"=>"94.40"
                ],
                [
                    "id"=>10011,
                    "username"=>"user-11",
                    "sex"=>1,
                    "city"=>3,
                    "sign"=>"签名-11",
                    "experience"=>1014,
                    "logins"=>15,
                    "wealth"=>74173151,
                    "classify"=>4,
                    "score"=>"12.68"
                ],
                [
                    "id"=>10012,
                    "username"=>"user-12",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-12",
                    "experience"=>332,
                    "logins"=>48,
                    "wealth"=>14365229,
                    "classify"=>0,
                    "score"=>"86.82"
                ],
                [
                    "id"=>10013,
                    "username"=>"user-13",
                    "sex"=>1,
                    "city"=>2,
                    "sign"=>"签名-13",
                    "experience"=>405,
                    "logins"=>120,
                    "wealth"=>34695563,
                    "classify"=>0,
                    "score"=>"33.42"
                ],
                [
                    "id"=>10014,
                    "username"=>"user-14",
                    "sex"=>1,
                    "city"=>2,
                    "sign"=>"签名-14",
                    "experience"=>1026,
                    "logins"=>72,
                    "wealth"=>90734164,
                    "classify"=>2,
                    "score"=>"75.31"
                ],
                [
                    "id"=>10015,
                    "username"=>"user-15",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-15",
                    "experience"=>916,
                    "logins"=>32,
                    "wealth"=>90446407,
                    "classify"=>0,
                    "score"=>"86.95"
                ],
                [
                    "id"=>10016,
                    "username"=>"user-16",
                    "sex"=>0,
                    "city"=>3,
                    "sign"=>"签名-16",
                    "experience"=>1086,
                    "logins"=>148,
                    "wealth"=>43784209,
                    "classify"=>1,
                    "score"=>"30.62"
                ],
                [
                    "id"=>10017,
                    "username"=>"user-17",
                    "sex"=>1,
                    "city"=>0,
                    "sign"=>"签名-17",
                    "experience"=>675,
                    "logins"=>11,
                    "wealth"=>42448971,
                    "classify"=>4,
                    "score"=>"74.11"
                ],
                [
                    "id"=>10018,
                    "username"=>"user-18",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-18",
                    "experience"=>576,
                    "logins"=>42,
                    "wealth"=>85830822,
                    "classify"=>4,
                    "score"=>"42.84"
                ],
                [
                    "id"=>10019,
                    "username"=>"user-19",
                    "sex"=>0,
                    "city"=>2,
                    "sign"=>"签名-19",
                    "experience"=>196,
                    "logins"=>54,
                    "wealth"=>51475132,
                    "classify"=>4,
                    "score"=>"15.24"
                ],
                [
                    "id"=>10020,
                    "username"=>"user-20",
                    "sex"=>1,
                    "city"=>3,
                    "sign"=>"签名-20",
                    "experience"=>283,
                    "logins"=>65,
                    "wealth"=>73233524,
                    "classify"=>2,
                    "score"=>"83.49"
                ],
                [
                    "id"=>10021,
                    "username"=>"user-21",
                    "sex"=>0,
                    "city"=>2,
                    "sign"=>"签名-21",
                    "experience"=>867,
                    "logins"=>157,
                    "wealth"=>28876711,
                    "classify"=>1,
                    "score"=>"62.48"
                ],
                [
                    "id"=>10022,
                    "username"=>"user-22",
                    "sex"=>1,
                    "city"=>0,
                    "sign"=>"签名-22",
                    "experience"=>163,
                    "logins"=>124,
                    "wealth"=>81671948,
                    "classify"=>1,
                    "score"=>"87.03"
                ],
                [
                    "id"=>10023,
                    "username"=>"user-23",
                    "sex"=>1,
                    "city"=>1,
                    "sign"=>"签名-23",
                    "experience"=>799,
                    "logins"=>55,
                    "wealth"=>22322407,
                    "classify"=>0,
                    "score"=>"8.18"
                ],
                [
                    "id"=>10024,
                    "username"=>"user-24",
                    "sex"=>0,
                    "city"=>1,
                    "sign"=>"签名-24",
                    "experience"=>420,
                    "logins"=>86,
                    "wealth"=>97581235,
                    "classify"=>1,
                    "score"=>"6.86"
                ],
                [
                    "id"=>10025,
                    "username"=>"user-25",
                    "sex"=>1,
                    "city"=>2,
                    "sign"=>"签名-25",
                    "experience"=>766,
                    "logins"=>83,
                    "wealth"=>51342572,
                    "classify"=>2,
                    "score"=>"11.04"
                ],
                [
                    "id"=>10026,
                    "username"=>"user-26",
                    "sex"=>0,
                    "city"=>3,
                    "sign"=>"签名-26",
                    "experience"=>725,
                    "logins"=>107,
                    "wealth"=>39802662,
                    "classify"=>0,
                    "score"=>"40.83"
                ],
                [
                    "id"=>10027,
                    "username"=>"user-27",
                    "sex"=>1,
                    "city"=>1,
                    "sign"=>"签名-27",
                    "experience"=>649,
                    "logins"=>118,
                    "wealth"=>87274288,
                    "classify"=>4,
                    "score"=>"17.97"
                ],
                [
                    "id"=>10028,
                    "username"=>"user-28",
                    "sex"=>1,
                    "city"=>3,
                    "sign"=>"签名-28",
                    "experience"=>1074,
                    "logins"=>161,
                    "wealth"=>55614074,
                    "classify"=>0,
                    "score"=>"83.21"
                ],
                [
                    "id"=>10029,
                    "username"=>"user-29",
                    "sex"=>1,
                    "city"=>0,
                    "sign"=>"签名-29",
                    "experience"=>740,
                    "logins"=>177,
                    "wealth"=>12630674,
                    "classify"=>4,
                    "score"=>"77.64"
                ]
            ]
        ];
        return $this->_result();
    }

}