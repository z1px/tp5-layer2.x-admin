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
        'title'=>'require|unique:auth_group,title',
        'rules'=>'require',
        'status'=>'in:1,2',
    ];

    // 错误提示
    protected $message = [

    ];

    // 验证场景
    protected $scene = [
        'add'=>['title','rules','status'],
        'edit'=>['id','title','rules','status'],
        'edit_status'=>['id','status'],
    ];

}