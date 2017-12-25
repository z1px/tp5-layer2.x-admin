<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/12
 * Time: 16:24
 */

namespace app\admin\behavior;


use app\admin\controller\Common;
use app\admin\model\BehaviorLog as BehaviorLogModel;
use think\Config;
use think\Cookie;
use think\Request;

class BehaviorLog extends Common {

    public function run(&$params,$extra=[]){

        if(empty($this->request)) $this->request=Request::instance();

        if(!$this->request->isPost() && !$this->request->isAjax()) return ;

        $allow_action=["add","edit","del","myinfo","editstatus"];
        if(!in_array(strtolower($this->request->action()),$allow_action)) return ;

        $row=[
            "title"=>isset(Config::get("behavior_title")[strtolower($this->request->module())][strtolower($this->request->controller())][strtolower($this->request->action())])?Config::get("behavior_title")[strtolower($this->request->module())][strtolower($this->request->controller())][strtolower($this->request->action())]:"",
            "module"=>$this->request->module(),
            "controller"=>$this->request->controller(),
            "action"=>$this->request->action(),
            "url"=>$this->request->url(true),
            "type"=>"",
            "request"=>empty($this->params)?"":json_encode($this->params),
            "response"=>empty($this->result)?"":json_encode($this->result),
            "admin_id"=>isset($this->account["id"])?Cookie::get("login_id"):$this->account["id"],
            "username"=>isset($this->account["username"])?Cookie::get("login_name"):$this->account["username"]
        ];
        if($this->request->isGet()){
            $row["type"][]="get";
        }elseif($this->request->isPost()){
            $row["type"][]="post";
        }elseif($this->request->isPut()){
            $row["type"][]="put";
        }elseif($this->request->isDelete()){
            $row["type"][]="delete";
        }elseif($this->request->isAjax()){
            $row["type"][]="ajax";
        }elseif($this->request->isPjax()){
            $row["type"][]="pjax";
        }elseif($this->request->isMobile()){
            $row["type"][]="mobile";
        }elseif($this->request->isHead()){
            $row["type"][]="head";
        }elseif($this->request->isPatch()){
            $row["type"][]="patch";
        }elseif($this->request->isOptions()){
            $row["type"][]="options";
        }elseif($this->request->isCli()){
            $row["type"][]="cli";
        }elseif($this->request->isCgi()){
            $row["type"][]="cgi";
        }
        $row["type"]=implode("|",$row["type"]);

        $behaviorLog=new BehaviorLogModel();
        $behaviorLog->save($row);
        unset($row);
    }

}