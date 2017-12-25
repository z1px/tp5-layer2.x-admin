<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 11:33
 */

namespace app\admin\service;


use \app\admin\model\LoginLog as LoginLogModel;

class LoginLog extends LoginLogModel {


    public function getList($row){

        if(!isset($row["pageIndex"])) $row["pageIndex"]=1;
        if(!isset($row["pageSize"])) $row["pageSize"]=10;
        $where=[];
        $order="id desc";
        if(isset($row["keyword"]) && !empty($row["keyword"])) $where["username|account"]=["like","%{$row["keyword"]}%"];
        array_map(function ($value) use (&$where,$row){
            if(isset($row[$value]) && !empty($row[$value])) $where[$value]=$row[$value];
        },
            ["admin_id","username"]
        );
        if(isset($row["field"])){
            if(!empty($row["field"])){
                if($row["field"]=="status_name") $row["field"]="status";
                $order="{$row["field"]} {$row["order"]}";
            }
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

        $list=$this->field("id,admin_id,username,account,ip,area,create_time")->where($where)->page($row["pageIndex"],$row["pageSize"])->order($order)->select();
        $this->result["rel"]=true;
        $this->result["count"]=$this->where($where)->Count();
        unset($row,$where);
        if(empty($list)){
            $list=[];
        }else{
            foreach ($list as $key=>$value){
                if(!empty($value->account)) $value->account=var_export(json_decode($value->account,true),true);
                $list[$key]=$value->toArray();
            }
            unset($key,$value);
        }
        $this->result["list"]=$list;
        unset($list);
        return $this->result;
    }

}