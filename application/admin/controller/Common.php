<?php
/**
 * Created by PhpStorm.
 * User: 乐
 * Date: 2017/12/21
 * Time: 11:25
 */

namespace app\admin\controller;


use think\Config;
use think\Controller;
use think\exception\HttpException;
use think\Hook;
use think\Log;
use think\Request;

class Common extends Controller{

    public function _empty(){
        // 抛出HTTP异常 并发送404状态码
        throw new HttpException(404,'method not exists');
    }

    //请求信息
    protected $request;
    //请求参数
    protected $params;
    //返回结果
    protected $result=[
        "code"=>1,
        "msg"=>"data normal",
        "data"=>[],
    ];

    protected $beforeActionList = [
        '_init',
        '_menu'=>['except'=>'login,logout'],
        '_before'
    ];

    /**
     * 初始化
     * @return array
     */
    protected function _init(){
        $this->request = Request::instance();
        $this->params = $this->request->param();
    }

    /**
     * 菜单
     * @return array
     */
    protected function _menu(){

    }

    /**
     * 前置操作
     * @return array
     */
    protected function _before(){

    }

    /**
     * 返回json结果
     * @param int $code
     * @return mixed
     */
    protected function _result() {

        Config::set('default_return_type','json');

        unset($this->params,$this->request);

        return $this->result;
    }

    /**
     * 返回结果
     * @param int $code
     * @return mixed
     */
    protected function _fetch($fetch=[]) {

        Config::set('default_return_type','html');

        unset($this->params,$this->request,$this->result);

        return $this->fetch("",$fetch);
    }

    /**
     * 返回结果
     * @param int $code
     * @return mixed
     */
    protected function _jump($url=null) {

        Config::set('default_return_type','html');

        unset($this->params,$this->request);

        if($this->result["code"]==1){
            $this->success($this->result["msg"],$url,$this->result["data"]);
        }else{
            $this->error($this->result["msg"],$url,$this->result["data"]);
        }
    }

}