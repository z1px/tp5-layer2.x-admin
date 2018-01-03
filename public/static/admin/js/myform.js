layui.define(['form','laydate','layer','upload'], function(exports) {
    var form = layui.form,
        laydate = layui.laydate,
        upload = layui.upload,
        layer = layui.layer,
        layerTips = parent.layer === undefined ? layui.layer : parent.layer; //获取父窗口的layer对象

    // 当form表单在顶级窗口时，显示form表单提交按钮，作为单独的页面
    if(top.location==self.location){
        $("#form_btn").show();
    }

    var myform = {
        config: {
            url:'',
            upload_img:{
                elem: '#upload_img', //绑定元素
                url: "", //上传接口
                method: 'post', //上传接口的http类型
                data:{},//请求上传接口的额外参数
                accept: 'images', //指定允许上传的文件类型，可选值有：images（图片）、file（所有文件）、video（视频）、audio（音频）
                drag:true,//是否接受拖拽的文件上传，设置 false 可禁用
                size: 2048, //最大允许上传的文件大小,单位 KB
                elem_btn:"input[name=img]",//图片上传完之后地址绑定的表单
                elem_img:"#img",//图片上传完之后图片预览绑定的元素
            },
            form_verify:{
                username: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                        return '用户名不能有特殊字符';
                    }
                    if(/(^\_)|(\__)|(\_+$)/.test(value)){
                        return '用户名首尾不能出现下划线\'_\'';
                    }
                    if(/^\d+\d+\d$/.test(value)){
                        return '用户名不能全为数字';
                    }
                },
                phone:function (value) {
                    if(value){
                        if(!/^1[34578][0-9]{9}$/.test(value)){
                            return '手机号格式不正确';
                        }
                    }
                },
                email:function (value) {
                    if(value){
                        if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)){
                            return '邮箱号格式不正确';
                        }
                    }
                },
                password: function (value) {
                    var pwd=$("input[name=password]").val();
                    if(!$("input[name=id]").val()||($("input[name=id]").length>0&&pwd)){
                        if(!/^[\S]{6,12}$/.test(value)){
                            return '密码必须6到12位，且不能出现空格';
                        }
                    }

                },
                check_password: function(value) {
                    var pwd=$("input[name=password]").val();
                    if(value!=pwd){
                        return '两次密码不一致';
                    }
                }
            },
            // 时间控件配置参数
            laydate:{
                elem: '#date', // 绑定元素
                type: 'date', //控件选择类型，year，month，date，time，datetime
                range:false, // 开启左右面板范围选择，'~' 来自定义分割字符
                // format :'yyyy-MM-dd HH:mm:ss', // 自定义格式
                format :'yyyy-MM-dd', // 自定义格式
                value :'', // 初始值
                min: "2015-01-01 00:00:00", // 最小/大范围内的日期时间值
                // max: laydate.now(),
                trigger: 'click', //自定义弹出控件的事件,采用click弹出
                show: true, //默认显示
                position: 'absolute', //定位方式
                zIndex: 66666666, //层叠顺序
                showBottom: true, //是否显示底部栏
                btns: ['clear', 'now', 'confirm'], //工具按钮
                lang: 'cn', //语言
                theme: 'default', //主题
                calendar: false, //是否显示公历节日
                mark : {}, //标注重要日子
                ready: function(date){// 控件初始打开的回调
                    // console.log(date); //得到初始的日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                },
                change: function(value, date, endDate){ //日期时间被切换后的回调
                    // console.log(value); //得到日期生成的值，如：2017-08-18
                    // console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                    // console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                    // ins1.hint(value); //在控件上弹出value值
                },
                done: function(value, date, endDate){//控件选择完毕后的回调
                    // console.log(value); //得到日期生成的值，如：2017-08-18
                    // console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                    // console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                }
            }
        },
        set: function(options) {
            var that = this;
            $.extend(true, that.config, options);
            return that;
        },
        init: function() {
            var that = this,
                _config = that.config;

            //执行实例
            var uploadInst = upload.render({
                elem: _config.upload_img.elem, //绑定元素
                url: _config.upload_img.url, //上传接口
                method: _config.upload_img.method, //上传接口的http类型
                data:_config.upload_img.data,//请求上传接口的额外参数
                accept: _config.upload_img.accept, //指定允许上传的文件类型，可选值有：images（图片）、file（所有文件）、video（视频）、audio（音频）
                drag:_config.upload_img.drag,//是否接受拖拽的文件上传，设置 false 可禁用
                size: _config.upload_img.size, //最大允许上传的文件大小,单位 KB
                before:function () {
                    ind_load=layerTips.msg('图片上传中...',{icon: 16,shade: 0.01});
                },
                done: function(res, index, upload){
                    layerTips.close(ind_load);
                    //上传完毕回调
                    layerTips.msg(res.msg);
                    if(res.code==0){
                        $(_config.upload_img.elem_btn).val(res.data.src);
                        $(_config.upload_img.elem_img).attr("src",res.data.src);
                    }
                },
                error: function(index, upload){
                    //请求异常回调
                    layerTips.close(ind_load);
                    layerTips.msg("请求异常");
                }
            });

            //自定义验证规则
            form.verify(_config.form_verify);

            //监听提交
            form.on('submit(form_myinfo)', function(data){
                var ind_load=layerTips.load(2);
                $.ajax({
                    type:"post",
                    url:_config.url,
                    data:data.field,
                    timeout : 5000, //超时时间设置，单位毫秒
                    dataType:"json",
                    async: true, // 异步加载
                    beforeSend:function(){

                    },success:function(result){
                        layerTips.close(ind_load);
                        layerTips.alert(result.msg,{closeBtn:0},function () {
                            if(result.code==1){
                                window.top.location.reload(); //刷新框架
                            }
                        });
                        return false;
                    },complete:function(XMLHttpRequest){
                        if(XMLHttpRequest.statusText=="timeout"){
                            layerTips.close(ind_load);
                            layerTips.msg("请求超时...");
                        }
                    },error:function(){
                        layerTips.close(ind_load);
                        layerTips.msg("请求错误");
                    }
                });

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

            //监听提交
            form.on('submit(demo)', function(data){
                var ind_load=layerTips.load(2);
                $.ajax({
                    type:"post",
                    url:_config.url,
                    data:data.field,
                    timeout : 5000, //超时时间设置，单位毫秒
                    dataType:"json",
                    async: true, // 异步加载
                    beforeSend:function(){

                    },success:function(result){
                        layerTips.close(ind_load);
                        layerTips.msg(result.msg,{closeBtn:0});
                        return false;
                    },complete:function(XMLHttpRequest){
                        if(XMLHttpRequest.statusText=="timeout"){
                            layerTips.close(ind_load);
                            layerTips.msg("请求超时...");
                        }
                    },error:function(){
                        layerTips.close(ind_load);
                        layerTips.msg("请求错误");
                    }
                });

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

            //外部事件调用
            lay('#date').on('click', function(e){ //假设 date 是一个按钮
                laydate.render(_config.laydate);
            });

            var begin = _config.laydate;
            var end = _config.laydate;
            //外部事件调用
            lay('input[name=begin_time]').on('click', function(e){ //假设 date 是一个按钮
                begin.elem = this;
                begin.done = function (value, date, endDate) {
                    end.min = value; //开始日选好后，重置结束日的最小日期
                };
                laydate.render(begin);
            });
            //外部事件调用
            lay('input[name=end_time]').on('click', function(e){ //假设 date 是一个按钮
                end.elem = this;
                laydate.render(end);
            });
        }
    };

    //输出test接口
    exports('myform', myform);
});
