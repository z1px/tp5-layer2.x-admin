<?php
/**
 * Created by PhpStorm.
 * User: 乐
 * Date: 2017/12/21
 * Time: 11:25
 */

namespace app\admin\controller;


use think\exception\HttpException;
use think\Lang;

class Error {

    public function _empty(){
        // 抛出HTTP异常 并发送404状态码
        throw new HttpException(404,Lang::get('controller not exists'));
    }

}