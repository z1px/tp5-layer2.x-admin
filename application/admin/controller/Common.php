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
     * 导出到csv文档
     * @param int $code
     * @return mixed
     */
    protected function _export($callback) {

        Config::set('default_return_type','html');
        ini_set('max_execution_time', '0'); // 设置不超时
        ini_set("memory_limit","-1"); // 设置不限制内存

        if($this->result["code"]==1){

            $this->params["page"]=1;
            $this->params["limit"]=100;

            $this->result=$this->result=$callback($this->params);

            if(!isset($this->result["filename"])||empty($this->result["filename"])) $this->result["filename"]="{$this->request->controller()}_{$this->request->action()}";
            if(!isset($this->result["count"])) $this->result["count"]=0;

            ob_start();
            ob_end_clean();  //清空缓存
            Header("Content-type: application/octet-stream"); #通过这句代码客户端浏览器就能知道服务端返回的文件形式
            Header("Accept-Ranges: bytes"); #告诉客户端浏览器返回的文件大小是按照字节进行计算的
            Header("Content-Disposition: attachment; filename={$this->result["filename"]}.csv"); #告诉浏览器返回的文件的名称

            $file = fopen("php://output", 'w');
            fwrite($file,chr(0xEF).chr(0xBB).chr(0xBF));

            if(isset($this->result["title"])&&is_array($this->result["title"])&&!empty($this->result["title"])) fputcsv($file, $this->result["title"]);

            $func = function() use ($file){
                if(isset($this->result["list"])&&!empty($this->result["list"])){
                    array_map(function ($data) use ($file){
                        fputcsv($file, $data);
                        unset($data);
                    },$this->result["list"]);
                }
            };

            $func();//page=1先执行一次
            $this->params["page"]++;
            while ($this->params["page"]<=ceil($this->result["count"]/$this->params["limit"])){
                $this->result=$callback($this->params);
                $func();
                $this->params["page"]++;
                ob_flush();//刷新输出缓冲到浏览器
                flush();//必须同时使用 ob_flush() 和flush() 函数来刷新输出缓冲。
            }
            unset($func,$callback);
            fclose($file);
        }else{
            $this->error($this->result["msg"]);
        }
    }

    //刷新文本输出缓冲到浏览器
    protected function _flush($file){
        Config::set('default_return_type','html');
        ini_set('max_execution_time', '0'); // 设置不超时

        ob_start();
        ob_end_clean();  //清空缓存

        //打开文件并将指针指向最后一行
        $func = function ($file){
            if(!is_file($file)) exit("Unable to open file!");
            $fp = fopen($file, "r");
            $pos = -2;      //偏移量
            $eof = " ";     //行尾标识
            while ($eof != "\n"){ //不是行尾
                fseek($fp, $pos, SEEK_END);//fseek成功返回0，失败返回-1
                $eof = fgetc($fp);//读取一个字符并赋给行尾标识
                $pos--;//向前偏移
            }
            unset($pos,$eof);
            return $fp;
        };
        //打开文件并设定位置等于 offset 字节
        $func1 = function ($file,$pos){
            if(!is_file($file)) exit("Unable to open file!");
            $fp = fopen($file, "r");
            fseek($fp, $pos, SEEK_SET);//fseek成功返回0，失败返回-1
            return $fp;
        };

        $fp = $func($file);
        $pos = ftell($fp);
        while (true){
            if(feof($fp)){
                $fp = $func1($file,$pos);
                echo ".";
            }else{
                while ($r = fgets($fp)){
                    echo $r,"<br/>";
                }
                $pos = ftell($fp);
                ob_flush();//刷新输出缓冲到浏览器
                flush();//必须同时使用 ob_flush() 和flush() 函数来刷新输出缓冲。
                sleep(1);
            }
        }
        fclose($fp);
    }

}