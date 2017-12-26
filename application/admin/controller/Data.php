<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 16:43
 */

namespace app\admin\controller;


use think\Config;
use think\Request;
use think\Url;

class Data extends Common {

    protected function _before() {

    }

    public function onelevel(){
        $this->result = Config::get("onelevel");
        return $this->_result();
    }

    public function navbar(){
        $this->result = Config::get("navbar.{$this->request->param("id",0)}");
        return $this->_result();
    }

    public function table(){
        $this->result = Config::get("table");
        return $this->_result();
    }

    public function menu(){
        $this->result = array (
            0 =>
                array (
                    'id' => '72',
                    'title' => 'SDK平台用户管理',
                    'pid' => '0',
                    "open" => 'true',
                ),
            1 =>
                array (
                    'id' => '78',
                    'title' => '订单列表',
                    'pid' => '77',
                    "open" => 'true'
                ),
            2 =>
                array (
                    'id' => '41',
                    'title' => 'CP管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            3 =>
                array (
                    'id' => '43',
                    'title' => 'SDK平台管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            4 =>
                array (
                    'id' => '77',
                    'title' => '订单管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            5 =>
                array (
                    'id' => '79',
                    'title' => 'SDK日志管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            6 =>
                array (
                    'id' => '1',
                    'title' => '白名单菜单',
                    'pid' => '0',
                    "open" => 'true'
                ),
            7 =>
                array (
                    'id' => '2',
                    'title' => '系统菜单',
                    'pid' => '0',
                    "open" => 'true'
                ),
            8 =>
                array (
                    'id' => '3',
                    'title' => '用户管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            9 =>
                array (
                    'id' => '4',
                    'title' => '菜单管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            10 =>
                array (
                    'id' => '5',
                    'title' => '管理员列表',
                    'pid' => '3',
                    "open" => 'true'
                ),
            11 =>
                array (
                    'id' => '6',
                    'title' => '管理员分组列表',
                    'pid' => '3',
                    "open" => 'true'
                ),
            12 =>
                array (
                    'id' => '7',
                    'title' => '菜单列表',
                    'pid' => '4',
                    "open" => 'true'
                ),
            13 =>
                array (
                    'id' => '8',
                    'title' => '新增管理员',
                    'pid' => '5',
                    "open" => 'true'
                ),
            14 =>
                array (
                    'id' => '9',
                    'title' => '修改管理员信息',
                    'pid' => '5',
                    "open" => 'true'
                ),
            15 =>
                array (
                    'id' => '10',
                    'title' => '删除管理员',
                    'pid' => '5',
                    "open" => 'true'
                ),
            16 =>
                array (
                    'id' => '11',
                    'title' => '添加用户组',
                    'pid' => '6',
                    "open" => 'true'
                ),
            17 =>
                array (
                    'id' => '12',
                    'title' => '登录',
                    'pid' => '2',
                    "open" => 'true'
                ),
            18 =>
                array (
                    'id' => '13',
                    'title' => '退出',
                    'pid' => '2',
                    "open" => 'true'
                ),
            19 =>
                array (
                    'id' => '14',
                    'title' => '添加菜单',
                    'pid' => '7',
                    "open" => 'true'
                ),
            20 =>
                array (
                    'id' => '15',
                    'title' => '删除菜单',
                    'pid' => '7',
                    "open" => 'true'
                ),
            21 =>
                array (
                    'id' => '16',
                    'title' => '修改菜单',
                    'pid' => '7',
                    "open" => 'true'
                ),
            22 =>
                array (
                    'id' => '17',
                    'title' => '首页',
                    'pid' => '2',
                    "open" => 'true'
                ),
            23 =>
                array (
                    'id' => '18',
                    'title' => '欢迎页',
                    'pid' => '2',
                    "open" => 'true'
                ),
            24 =>
                array (
                    'id' => '19',
                    'title' => '获取菜单信息',
                    'pid' => '2',
                    "open" => 'true'
                ),
            25 =>
                array (
                    'id' => '20',
                    'title' => '清除缓存',
                    'pid' => '2',
                    "open" => 'true'
                ),
            26 =>
                array (
                    'id' => '23',
                    'title' => '日志管理',
                    'pid' => '0',
                    "open" => 'true'
                ),
            27 =>
                array (
                    'id' => '24',
                    'title' => '登录日志',
                    'pid' => '23',
                    "open" => 'true'
                ),
            28 =>
                array (
                    'id' => '25',
                    'title' => '行为日志',
                    'pid' => '23',
                    "open" => 'true'
                ),
            29 =>
                array (
                    'id' => '26',
                    'title' => '锁屏',
                    'pid' => '2',
                    "open" => 'true'
                ),
            30 =>
                array (
                    'id' => '27',
                    'title' => '解除锁屏',
                    'pid' => '2',
                    "open" => 'true'
                ),
            31 =>
                array (
                    'id' => '28',
                    'title' => '设置',
                    'pid' => '2',
                    "open" => 'true'
                ),
            32 =>
                array (
                    'id' => '29',
                    'title' => '修改个人信息',
                    'pid' => '2',
                    "open" => 'true'
                ),
            33 =>
                array (
                    'id' => '30',
                    'title' => '修改管理员账号状态',
                    'pid' => '5',
                    "open" => 'true'
                ),
            34 =>
                array (
                    'id' => '31',
                    'title' => '修改用户组',
                    'pid' => '6',
                    "open" => 'true'
                ),
            35 =>
                array (
                    'id' => '32',
                    'title' => '修改用户组状态',
                    'pid' => '6',
                    "open" => 'true'
                ),
            36 =>
                array (
                    'id' => '33',
                    'title' => '删除用户组',
                    'pid' => '6',
                    "open" => 'true'
                ),
            37 =>
                array (
                    'id' => '35',
                    'title' => '修改菜单状态',
                    'pid' => '7',
                    "open" => 'true'
                ),
            38 =>
                array (
                    'id' => '37',
                    'title' => '菜单授权列表',
                    'pid' => '7',
                    "open" => 'true'
                ),
            39 =>
                array (
                    'id' => '38',
                    'title' => '获取所有菜单',
                    'pid' => '7',
                    "open" => 'true'
                ),
            40 =>
                array (
                    'id' => '39',
                    'title' => '修改菜单级别',
                    'pid' => '7',
                    "open" => 'true'
                ),
            41 =>
                array (
                    'id' => '40',
                    'title' => '修改菜单名称',
                    'pid' => '7',
                    "open" => 'true'
                ),
            42 =>
                array (
                    'id' => '42',
                    'title' => 'CP列表',
                    'pid' => '41',
                    "open" => 'true'
                ),
            43 =>
                array (
                    'id' => '44',
                    'title' => 'SDK平台列表',
                    'pid' => '43',
                    "open" => 'true'
                ),
            44 =>
                array (
                    'id' => '45',
                    'title' => '游戏管理',
                    'pid' => '41',
                    "open" => 'true'
                ),
            45 =>
                array (
                    'id' => '46',
                    'title' => 'SDK游戏管理',
                    'pid' => '43',
                    "open" => 'true'
                ),
            46 =>
                array (
                    'id' => '47',
                    'title' => '事件管理',
                    'pid' => '41',
                    "open" => 'true'
                ),
            47 =>
                array (
                    'id' => '48',
                    'title' => '添加CP',
                    'pid' => '42',
                    "open" => 'true'
                ),
            48 =>
                array (
                    'id' => '49',
                    'title' => '修改CP',
                    'pid' => '42',
                    "open" => 'true'
                ),
            49 =>
                array (
                    'id' => '50',
                    'title' => '删除CP',
                    'pid' => '42',
                    "open" => 'true'
                ),
            50 =>
                array (
                    'id' => '51',
                    'title' => '修改CP状态',
                    'pid' => '42',
                    "open" => 'true'
                ),
            51 =>
                array (
                    'id' => '52',
                    'title' => '添加游戏',
                    'pid' => '45',
                    "open" => 'true'
                ),
            52 =>
                array (
                    'id' => '53',
                    'title' => '修改游戏',
                    'pid' => '45',
                    "open" => 'true'
                ),
            53 =>
                array (
                    'id' => '54',
                    'title' => '删除游戏',
                    'pid' => '45',
                    "open" => 'true'
                ),
            54 =>
                array (
                    'id' => '55',
                    'title' => '修改游戏状态',
                    'pid' => '45',
                    "open" => 'true'
                ),
            55 =>
                array (
                    'id' => '56',
                    'title' => '添加SDK平台',
                    'pid' => '44',
                    "open" => 'true'
                ),
            56 =>
                array (
                    'id' => '57',
                    'title' => '修改SDK平台',
                    'pid' => '44',
                    "open" => 'true'
                ),
            57 =>
                array (
                    'id' => '58',
                    'title' => '删除SDK平台',
                    'pid' => '44',
                    "open" => 'true'
                ),
            58 =>
                array (
                    'id' => '59',
                    'title' => '修改SDK平台状态',
                    'pid' => '44',
                    "open" => 'true'
                ),
            59 =>
                array (
                    'id' => '60',
                    'title' => '添加SDK游戏',
                    'pid' => '46',
                    "open" => 'true'
                ),
            60 =>
                array (
                    'id' => '61',
                    'title' => '修改SDK游戏',
                    'pid' => '46',
                    "open" => 'true'
                ),
            61 =>
                array (
                    'id' => '62',
                    'title' => '删除SDK游戏',
                    'pid' => '46',
                    "open" => 'true'
                ),
            62 =>
                array (
                    'id' => '63',
                    'title' => '修改SDK游戏菜单',
                    'pid' => '46',
                    "open" => 'true'
                ),
            63 =>
                array (
                    'id' => '64',
                    'title' => '添加事件',
                    'pid' => '47',
                    "open" => 'true'
                ),
            64 =>
                array (
                    'id' => '65',
                    'title' => '修改事件',
                    'pid' => '47',
                    "open" => 'true'
                ),
            65 =>
                array (
                    'id' => '66',
                    'title' => '删除事件',
                    'pid' => '47',
                    "open" => 'true'
                ),
            66 =>
                array (
                    'id' => '67',
                    'title' => '平台充值额度',
                    'pid' => '43',
                    "open" => 'true'
                ),
            67 =>
                array (
                    'id' => '68',
                    'title' => '添加额度账户',
                    'pid' => '67',
                    "open" => 'true'
                ),
            68 =>
                array (
                    'id' => '69',
                    'title' => '修改额度信息',
                    'pid' => '67',
                    "open" => 'true'
                ),
            69 =>
                array (
                    'id' => '70',
                    'title' => '平台额度充值',
                    'pid' => '67',
                    "open" => 'true'
                ),
            70 =>
                array (
                    'id' => '71',
                    'title' => '额度充值记录',
                    'pid' => '43',
                    "open" => 'true'
                ),
            71 =>
                array (
                    'id' => '73',
                    'title' => 'SDK用户管理',
                    'pid' => '72',
                    "open" => 'true'
                ),
            72 =>
                array (
                    'id' => '74',
                    'title' => 'SDK角色管理',
                    'pid' => '72',
                    "open" => 'true'
                ),
            73 =>
                array (
                    'id' => '75',
                    'title' => 'SDK登录日志',
                    'pid' => '72',
                    "open" => 'true'
                ),
            74 =>
                array (
                    'id' => '76',
                    'title' => '修改SDK用户状态',
                    'pid' => '73',
                    "open" => 'true'
                ),
            75 =>
                array (
                    'id' => '80',
                    'title' => 'SDK行为日志',
                    'pid' => '79',
                    "open" => 'true'
                ),
            76 =>
                array (
                    'id' => '81',
                    'title' => 'CP回调日志',
                    'pid' => '79',
                    "open" => 'true'
                ),
            77 =>
                array (
                    'id' => '82',
                    'title' => 'SDK版本更新',
                    'pid' => '43',
                    "open" => 'true'
                ),
            78 =>
                array (
                    'id' => '83',
                    'title' => '发布SDK新版本',
                    'pid' => '82',
                    "open" => 'true'
                ),
            79 =>
                array (
                    'id' => '84',
                    'title' => '修改SDK版本信息',
                    'pid' => '82',
                    "open" => 'true'
                ),
            80 =>
                array (
                    'id' => '85',
                    'title' => '修改SDK版本状态',
                    'pid' => '82',
                    "open" => 'true'
                ),
            81 =>
                array (
                    'id' => '86',
                    'title' => '删除SDK版本',
                    'pid' => '82',
                    "open" => 'true'
                ),
        );
        return $this->_result();
    }

}