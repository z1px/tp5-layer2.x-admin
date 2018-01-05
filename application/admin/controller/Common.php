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
use think\Loader;
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
    //当前登录用户信息
    protected $account;
    //返回结果
    protected $result;

    protected $beforeActionList = [
        '_init',
        '_auth'=>['except'=>'login,logout'],
        '_before'
    ];

    /**
     * 初始化
     * @return array
     */
    protected function _init(){
        $this->result=[
            "code"=>1,
            "msg"=>"data normal",
            "data"=>[],
        ];
        $this->request = Request::instance();
        $this->params = $this->request->param();
    }

    /**
     * 菜单
     * @return array
     */
    protected function _auth(){
        Hook::listen("check_auth",$this->account);
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

        $this->result = result_format($this->result);

        // 行为日志
        Hook::listen('behavior_log',$params,["request"=>$this->request,"account"=>$this->account,"params"=>$this->params,"result"=>$this->result]);

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

        // 行为日志
        Hook::listen('behavior_log',$params,["request"=>$this->request,"account"=>$this->account,"params"=>$this->params,"result"=>$this->result]);

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

        // 行为日志
        Hook::listen('behavior_log',$params,["request"=>$this->request,"account"=>$this->account,"params"=>$this->params,"result"=>$this->result]);

        unset($this->params,$this->request);

        if($this->result["code"]==1){
            $this->success($this->result["msg"],$url,$this->result["data"]);
        }else{
            $this->error($this->result["msg"],$url,$this->result["data"]);
        }
    }

    /**
     * 返回结果
     * @param int $code
     * @return mixed
     */
    protected function _export() {

        Config::set('default_return_type','html');
        ini_set('max_execution_time', '0');

        unset($this->params,$this->request);

        if($this->result["code"]==1){
            if(!isset($this->result["title"])||empty($this->result["title"])) $this->result["title"]=date("YmdHis");
            if(!isset($this->result["list"])) $this->result["list"]=[];
//            $this->success("开始下载");
            Loader::import("lib.PHPExcel");
            Loader::import("lib.PHPExcel.IOFactory");

            $phpexcel = new \PHPExcel();
            $phpexcel->getProperties()
                ->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
            $phpexcel->getActiveSheet()->fromArray($this->result["list"]);
            $phpexcel->getActiveSheet()->setTitle('Sheet1');
            $phpexcel->setActiveSheetIndex(0);

            /* 生成到浏览器，提供下载 */
            ob_end_clean();  //清空缓存
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=".$this->result["title"].".xls");
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objwriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
            $objwriter->save('php://output');

        }else{
            $this->error($this->result["msg"]);
        }
    }

}