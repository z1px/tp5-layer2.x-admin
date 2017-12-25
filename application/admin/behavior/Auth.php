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
use lib\Auth as AuthLib;

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
        $response->code($code);
        throw new HttpResponseException($response);
    }


    //权限检查
    public function CheckAuth(&$params,$extra=[]){

        $request=Request::instance();

        // 后台模块检查
        if(strtolower($request->module()) !== "admin") self::throwError();
        // 登录注销白名单
//        if(strtolower($request->controller()) === "index" && in_array(strtolower($request->action()),["login","logout"])) return true;
        // 登录检查
        $login=new Login();
        $this->result=$login->login_check();

        if($this->result["code"]!==1){
            self::redirect(Url::build("admin/Index/login"));
        }

        $auth=new AuthLib();
//        if(!$auth->check("{$request->module()}/{$request->controller()}/{$request->action()}",$this->result["data"]["id"])){
//            $this->result["code"]=0;
//            $this->result["msg"]="您所在的用户组没有该权限";
//            $this->result["data"] = [];
//            self::throwError();
//        }

        $params = $this->result["data"];
    }
}