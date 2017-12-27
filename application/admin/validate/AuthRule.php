<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 13:48
 */

namespace app\admin\validate;


use think\Validate;

class AuthRule extends Validate {

    // 验证规则
    protected $rule = [
        'id'=>'require|integer',
        'name'=>'require|unique:auth_rule,name',
        'title'=>'require',
        'icon'=>'require',
        'type'=>'require|number',
        'condition'=>'',
        'status'=>'in:1,2',
        'menu'=>'in:1,2',
    ];

    // 错误提示
    protected $message = [

    ];

    // 验证场景
    protected $scene = [
        'add'=>['name','title','icon','type','condition','status','menu'],
        'edit'=>['id','name','title','icon','type','condition','status','menu'],
        'edit_status'=>['id','status'],
        'edit_menu'=>['id','menu'],
    ];

}