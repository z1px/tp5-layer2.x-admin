<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/28
 * Time: 17:37
 */

namespace app\admin\service;


use \app\admin\model\BehaviorLog as BehaviorLogModel;

class BehaviorLog extends BehaviorLogModel {


    public function getList($params){

        if(!isset($params["page"])) $params["page"]=1;
        if(!isset($params["limit"])) $params["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($params["keyword"]) && !empty($params["keyword"])) $where["title|module|controller|action|url|request|response"]=["like","%{$params["keyword"]}%"];
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=["like","%{$params[$value]}%"];
        },
            ["title","request","response"]
        );
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=$params[$value];
        },
            ["module","controller","action","type","admin_id"]
        );
        if(isset($params["sort"]) && !empty($params["sort"])){
            $order="{$params["sort"]} {$params["order"]}";
        }
        if(isset($params["begin_end"])&&!empty($params["begin_end"])){
            $where["FROM_UNIXTIME(create_time,'%Y-%m-%d')"]=["between",array_map("trim",explode("~",$params["begin_end"]))];
        }

        $list=$this->field("id,admin_id,username,title,module,controller,action,url,type,request,response,ip,area,create_time")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);
        if(empty($list)){
            $list=[];
        }else{
            foreach ($list as $key=>$value){
                if(!empty($value->request)) $value->request=var_export(json_decode($value->request,true),true);
                if(!empty($value->response)) $value->response=var_export(json_decode($value->response,true),true);
                $list[$key]=$value->toArray();
            }
            unset($key,$value);
        }
        $this->result["list"]=$list;
        unset($list);
        return $this->result;
    }

}