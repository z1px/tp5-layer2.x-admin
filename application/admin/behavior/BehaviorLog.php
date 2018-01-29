<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/12
 * Time: 16:24
 */

namespace app\admin\behavior;


use app\admin\model\AuthRule;
use app\admin\model\BehaviorLog as BehaviorLogModel;
use think\Cookie;
use think\Request;

class BehaviorLog {

    public function run(&$params,$extra=[]){

        if(empty($extra)) return ;
        if(!isset($extra["request"]) || empty($extra["request"])) $extra["request"]=Request::instance();
        if(!isset($extra["account"])) $extra["account"]=[];
        if(!isset($extra["params"])) $extra["params"]=[];
        if(!isset($extra["result"])) $extra["result"]=[];

        if(!$extra["request"]->isPost() && !$extra["request"]->isAjax()) return ;

        $allow_action=["add","edit","del","myinfo","editstatus","editgroup"];
        if(!in_array(strtolower($extra["request"]->action()),$allow_action) && "upload"!=strtolower($extra["request"]->controller())) return ;

        $row=[
            "title"=>"",
            "module"=>$extra["request"]->module(),
            "controller"=>$extra["request"]->controller(),
            "action"=>$extra["request"]->action(),
            "url"=>$extra["request"]->url(true),
            "type"=>"",
            "request"=>empty($extra["params"])?"":json_encode($extra["params"]),
            "response"=>empty($extra["result"])?"":json_encode($extra["result"]),
            "admin_id"=>isset($extra["account"]["id"])?Cookie::get("login_id"):$extra["account"]["id"],
            "username"=>isset($extra["account"]["username"])?Cookie::get("login_name"):$extra["account"]["username"]
        ];
        $authRule = new AuthRule();
        $row["title"] = $authRule->where(["lower(name)"=>strtolower($extra["request"]->module()."/".$extra["request"]->controller()."/".$extra["request"]->action())])->value("title");
        unset($authRule);
        if($extra["request"]->isGet()){
            $row["type"]="get";
        }elseif($extra["request"]->isPost()){
            $row["type"]="post";
        }elseif($extra["request"]->isPut()){
            $row["type"]="put";
        }elseif($extra["request"]->isDelete()){
            $row["type"]="delete";
        }elseif($extra["request"]->isAjax()){
            $row["type"]="ajax";
        }elseif($extra["request"]->isPjax()){
            $row["type"]="pjax";
        }elseif($extra["request"]->isMobile()){
            $row["type"]="mobile";
        }elseif($extra["request"]->isHead()){
            $row["type"]="head";
        }elseif($extra["request"]->isPatch()){
            $row["type"]="patch";
        }elseif($extra["request"]->isOptions()){
            $row["type"]="options";
        }elseif($extra["request"]->isCli()){
            $row["type"]="cli";
        }elseif($extra["request"]->isCgi()){
            $row["type"]="cgi";
        }

        $behaviorLog=new BehaviorLogModel();
        $behaviorLog->save($row);
        unset($row);
    }

}