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


    public function getList($params){

        if(!isset($params["page"])) $params["page"]=1;
        if(!isset($params["limit"])) $params["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($params["keyword"]) && !empty($params["keyword"])) $where["username|account"]=["like","%{$params["keyword"]}%"];
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=$params[$value];
        },
            ["admin_id","username"]
        );
        if(isset($params["field"])){
            if(!empty($params["field"])){
                if($params["field"]=="status_name") $params["field"]="status";
                $order="{$params["field"]} {$params["order"]}";
            }
        }
        if(isset($params["begin_end"])&&!empty($params["begin_end"])){
            $where["FROM_UNIXTIME(create_time,'%Y-%m-%d')"]=["between",array_map("trim",explode("~",$params["begin_end"]))];
        }

        $list=$this->field("id,admin_id,username,account,ip,area,create_time")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["rel"]=true;
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);
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