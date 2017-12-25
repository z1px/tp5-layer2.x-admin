<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 13:48
 */

namespace app\admin\validate;


use think\Validate;

class AuthGroup extends Validate {

    // 验证规则
    protected $rule = [
        'id'=>'require|integer',
        'uid'=>'require',
        'group_id'=>'require',
    ];

    // 错误提示
    protected $message = [

    ];

    // 验证场景
    protected $scene = [

    ];

}