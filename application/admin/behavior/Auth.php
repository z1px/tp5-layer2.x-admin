<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 10:50
 */

namespace app\admin\behavior;


use app\admin\logic\Login;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\response\Redirect;
use think\Url;

class Auth {

    protected $result=[
        "code"=>0,
        "msg"=>"系统错误",
        "data"=>[]
    ];

    // 异常抛出
    protected function throwError(){
        throw new HttpResponseException(Response::create($this->result, "json"));
    }
    // 重定向
    protected function redirect($url, $code=302){
        $response = new Redirect($url);
        throw new HttpResponseException($response->code($code));
    }


    //权限检查
    public function run(){

        $request=Request::instance();

        // 后台模块检查
        if(strtolower($request->module()) !== "admin") self::throwError();
        // 登录注销白名单
        if(strtolower($request->controller()) === "index" && in_array(strtolower($request->action()),["login","logout"])) return true;
        // 登录检查
        $login=new Login();
        $this->result=$login->login_check();

        if($this->result["code"]!==1){
            self::redirect(Url::build("admin/Index/login"));
        }
    }
}