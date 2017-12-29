<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 10:50
 */

namespace app\admin\behavior;


use app\admin\logic\Login;
use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\response\Redirect;
use think\Url;
use app\admin\logic\Auth as AuthLib;
use think\View;

class Auth {

    protected $result=[
        "code"=>0,
        "msg"=>"系统错误",
        "data"=>[]
    ];

    // 异常抛出
    protected function throwError(){

        if(Request::instance()->isAjax()||Request::instance()->isPost()){
            $type = "json";
        }else{
            $type = "html";
            $this->result["url"]='javascript:history.back(-1);';
            $this->result = View::instance(Config::get('template'), Config::get('view_replace_str'))->fetch(Config::get('dispatch_error_tmpl'), $this->result);
        }
        throw new HttpResponseException(Response::create($this->result, $type));
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

        if($this->result["data"]["id"]!=1){
            $auth=new AuthLib();
            if(!$auth->check(strtolower("{$request->module()}/{$request->controller()}/{$request->action()}"),$this->result["data"]["id"])){
                $this->result["code"]=0;
                $this->result["msg"]="您所在的用户组没有该权限";
                $this->result["data"] = [];
                self::throwError();
            }
        }

        $params = $this->result["data"];
    }
}