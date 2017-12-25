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


    public function getList($row){

        if(!isset($row["pageIndex"])) $row["pageIndex"]=1;
        if(!isset($row["pageSize"])) $row["pageSize"]=10;
        $where=[];
        $order="id desc";
        if(isset($row["keyword"]) && !empty($row["keyword"])) $where["title|module|controller|action|url|request|response"]=["like","%{$row["keyword"]}%"];
        array_map(function ($value) use (&$where,$row){
            if(isset($row[$value]) && !empty($row[$value])) $where[$value]=["like","%{$row[$value]}%"];
        },
            ["title","request","response"]
        );
        array_map(function ($value) use (&$where,$row){
            if(isset($row[$value]) && !empty($row[$value])) $where[$value]=$row[$value];
        },
            ["module","controller","action","type","admin_id"]
        );
        if(isset($row["sort"]) && !empty($row["sort"])){
            $order="{$row["sort"]} {$row["order"]}";
        }
        if(!isset($row["begin_time"])) $row["begin_time"]="";
        if(!isset($row["end_time"])) $row["end_time"]="";
        if(!empty($row["begin_time"])&&empty($row["end_time"])){
            $where["create_time"]=["egt",strtotime($row["begin_time"])];
        }elseif(empty($row["begin_time"])&&!empty($row["end_time"])){
            $where["create_time"]=["elt",strtotime($row["end_time"])];
        }elseif(!empty($row["begin_time"])&&!empty($row["end_time"])){
            $where["create_time"]=["between",[strtotime($row["begin_time"]),strtotime($row["end_time"])]];
        }

        $list=$this->field("id,admin_id,username,title,module,controller,action,url,type,request,response,ip,area,create_time")->where($where)->page($row["pageIndex"],$row["pageSize"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($row,$where);
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