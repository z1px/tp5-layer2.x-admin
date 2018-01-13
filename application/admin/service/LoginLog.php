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

        if(isset($params["download"])&&$params["download"]==1) { // 导出到cvs文件并下载
            $order="id asc";
            $callback = function ($data){
                return array_values(array_map(function ($data){
                    return "\t{$data}";
                },$data));
            };
            if($params["page"]==1){
                $this->result["filename"]="BehaviorLog";
                $this->result["title"]=array_values([
                    "id"=>"\t编号",
                    "admin_id"=>"\t管理员ID",
                    "username"=>"\t管理员账号",
                    "account"=>"\t账号信息",
                    "ip"=>"\tIP",
                    "area"=>"\tIP区域",
                    "create_time"=>"\t登录时间",
                ]);
            }else{
                unset($this->result["filename"],$this->result["title"]);
            }
        }else{
            $callback = function ($data){
                if(isset($data["account"])&&!empty($data["account"])) $data["account"]=var_export(json_decode($data["account"],true),true);
                return $data;
            };
        }

        // 数据处理
        $func = function ($list) use ($callback){
            if(empty($list) || !is_array($list)) return [];
            return array_map(function ($data) use ($callback){
                return $callback($data->toArray());
            },$list);
        };

        $list=$this->field("id,admin_id,username,account,ip,area,create_time")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["rel"]=true;
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);

        $this->result["list"]=$func($list);
        unset($list);
        return $this->result;
    }

}