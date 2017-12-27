layui.define(['table','form','laytpl','laydate','layer','code','ztree'], function(exports) {
    var table = layui.table,
        form = layui.form,
        laytpl = layui.laytpl,
        laydate = layui.laydate,
        layer = layui.layer,
        layerTips = parent.layer === undefined ? layui.layer : parent.layer; //获取父窗口的layer对象

    var mytree = {
        config: {
            // 表格配置参数
            table:{
                elem: '#mytree', // 指定原始 table 容器的选择器或 DOM
                url: $("#mytree").data("url"), // 异步数据接口
                method: 'post', // 接口http请求类型
                request: { // 用于对分页请求的参数
                    pageName: 'page', //页码的参数名称，默认：page
                    limitName: 'limit' //每页数据量的参数名，默认：limit
                },
                response: { // 用于对返回的数据格式的自定义
                    statusName: 'code', //数据状态的字段名称，默认：code
                    statusCode: 1, //成功的状态码，默认：0
                    msgName: 'msg', //状态信息的字段名称，默认：msg
                    countName: 'count', //数据总数的字段名称，默认：count
                    dataName: 'list' //数据列表的字段名称，默认：data
                },
                height: 'full-50', // 设定容器高度，full-差值，高度将始终铺满，无论浏览器尺寸如何，高度最大化减去差值
                page: true, // 开启分页
                limit:10, // 每页显示的条数
                limits:[10,20,50,100], // 每页条数的选择项
                loading: true, // 加载条
                id: 'mytree', // 设定容器唯一ID
                // skin: 'line', //行边框风格
                // even: true, //开启隔行背景
                // size: 'sm', //小尺寸的表格
                cols: [],
                initSort: { //初始排序
                    field: 'id', //排序字段，对应 cols 设定的各字段名
                    type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                },
                done: function(res, curr, count) { // 数据渲染完的回调。你可以借此做一些其它的操作
                    //如果是异步请求数据方式，res即为你接口返回的信息。
                    //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                    // console.log(res);
                    // //得到当前页码
                    // console.log(curr);
                    // //得到数据总量
                    // console.log(count);
                },
                filter:'mytree'
            },
            // 弹窗配置参数
            open:{
                type: 2,//0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                title: "",
                maxmin: true, //最大最小化
                shade: 0.3, //遮罩
                id : 'demo', //用于控制弹层唯一标识
                area : 'auto',//宽高
                btnAlign: 'c', // 按钮排列
                content: "",
                edit:{
                    title: "修改",
                    url:$("#edit-tpl").data("url"),
                    btn: ["修改","重置","取消"],
                    content: "",
                    tpl: "#edit-tpl",
                    filter: "form-edit",
                    submit: "demo"
                },
                add:{
                    title: "添加",
                    url:$("#add-tpl").data("url"),
                    btn: ["添加","重置","取消"],
                    content: "",
                    tpl: "#add-tpl",
                    filter: "form-add",
                    submit: "demo"
                }
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
            },
            // zTree 配置项
            zTree:{
                url:'', //初始化数据源远程地址，如果datas存在则不请求
                elem:'#mytree',
                datas: null, // 初始化数据源
                view: {
                    dblClickExpand: true,
                    showLine: true,
                    showIcon: false,
                    selectedMulti: false
                },
                check: {
                    enable: true
                },
                data: {
                    simpleData: {
                        enable: true,
                        idKey: "id",
                        pIdKey: "pid"
                    },
                    key: {
                        name: "title"
                    }
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
            var tableIns = table.render(_config.table);

            var zTree;

            //监听搜索表单提交
            form.on('submit(search)', function(data) {
                // console.log(data.field);
                // layerTips.msg(JSON.stringify(data.field));
                //带条件查询
                tableIns.reload({
                    where: data.field
                });
                return false;
            });

            //监听工具条
            table.on('tool('+_config.table.filter+')', function(obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data; //获得当前行数据
                var layEvent = obj.event; //获得 lay-event 对应的值
                var tr = obj.tr; //获得当前行 tr 的DOM对象
                var that = $(this);

                switch(layEvent){
                    case 'view': //查看
                        // console.log(table.checkStatus(_config.table.filter));
                        // console.log(data);
                        //do somehing
                        break;
                    case 'view_arr': //查看数组
                        layerTips.open({
                            type: 1,
                            shadeClose: true,//点击遮罩关闭
                            title: false, //不显示标题
                            id: "demo", //用于控制弹层唯一标识
                            area: "auto",
                            content: '<pre class="layui-code">'+data[that.data("field")]+'</pre>',
                            success: function() {
                                layui.code({ // 加载code模块
                                    // elem: 'pre',//默认值为.layui-code
                                    // title: 'array', // 设置标题
                                    // height: '100px', //请注意必须加px。如果该key不设定，则会自适应高度，且不会出现滚动条。
                                    // encode: false, //是否转义html标签。默认不开启
                                    // skin: 'notepad', //如果要默认风格，不用设定该key。
                                    // about: false, //剔除关于
                                });
                            }
                        });
                        break;
                    case 'del': //删除
                        layerTips.confirm('真的删除'+(data.id?"ID为 "+data.id+" 的数据":"该行")+'吗', function(index) {
                            //向服务端发送删除指令
                            $.post(_config.table.url_del,{id:data.id},function (result) {
                                if(result.code==1){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                    layerTips.close(index);
                                }
                                layerTips.msg(result.msg);
                            },"json");
                        });
                        break;
                    case 'edit': //编辑
                        if(_config.open.type === 1){
                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"get",
                                url:_config.open.edit.url,
                                data:{id:data.id},
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: false, // 同步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    if(result.code==1){
                                        _config.open.edit.content = laytpl($(_config.open.edit.tpl).html()).render(result);
                                    }else{
                                        layerTips.msg(result.msg,{time: 2000});
                                        return false;
                                    }
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
                        }else if(_config.open.type ===2){
                            _config.open.edit.content = _config.open.edit.url+"?id="+data.id;
                        }else {
                            _config.open.edit.content = "";
                        }
                        var top_index = layerTips.open({
                            type: _config.open.type,//0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            title: _config.open.edit.title,
                            maxmin: _config.open.maxmin, //最大最小化
                            shade: _config.open.shade, //遮罩
                            id : _config.open.id, //用于控制弹层唯一标识
                            area : _config.open.area,//宽高
                            btnAlign: _config.open.btnAlign, // 按钮排列
                            btn: _config.open.edit.btn,
                            content: _config.open.edit.content,
                            yes: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    // var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                                    // console.log(body.html()); //得到iframe页的body内容
                                    var form_field = body.find('form[lay-filter='+_config.open.edit.filter+']').serializeArray();
                                    var field={};
                                    if(form_field){
                                        $.each(form_field,function (i,v){
                                            field[v.name]=v.value;
                                        })
                                    }
                                    if(zTree){
                                        var auth_rule_ids=[];
                                        var checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
                                        $.each(checked_ids, function (index, item) {
                                            auth_rule_ids.push(item.id);
                                        });
                                        field["rules"]=auth_rule_ids.toString(); // 数组转字符串
                                        checked_ids=null;
                                        auth_rule_ids=null;
                                    }
                                    var ind_load=layerTips.load(2);
                                    $.ajax({
                                        type:"post",
                                        url:_config.open.edit.url,
                                        data:field,
                                        timeout : 5000, //超时时间设置，单位毫秒
                                        dataType:"json",
                                        async: true, // 异步加载
                                        beforeSend:function(){

                                        },success:function(result){
                                            layerTips.close(ind_load);
                                            layerTips.msg(result.msg,{time: 2000});
                                            if(result.code==1){
                                                top_index && layerTips.close(top_index); //关闭弹出层
                                                //同步更新缓存对应的值
                                                obj.update(field);
                                            }
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
                                }else{
                                    $('form[lay-filter='+_config.open.edit.filter+']').find('button[lay-submit]').click();
                                }
                                // layerTips.close(index);
                                return false;
                            },
                            btn2: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    body.find('form[lay-filter='+_config.open.edit.filter+']').find('button[type="reset"]').click();
                                }else{
                                    $('form[lay-filter='+_config.open.edit.filter+']').find('button[type="reset"]').click();
                                }
                                return false;
                            },
                            success: function() {
                                form.render(null,_config.open.edit.filter);
                                var body = layerTips.getChildFrame('body', top_index);
                                if(_config.zTree.datas){
                                    zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, _config.zTree.datas);
                                }else{
                                    $.post(_config.zTree.url,{"group_id":data.id},function (data) {
                                        zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, data);
                                    });
                                }
                            },
                            cancel:function (index, layero) {
                                layerTips.confirm('若数据未保存，关闭后数据会丢失，确定要关闭吗？',function(ind){
                                    layerTips.close(ind);
                                    layerTips.close(index);
                                });
                                return false;
                            },
                            resizing:function(layero){ //拉伸时修改高度
                                // 提交按钮在 iframe层 里面时，必须加这一句，要不然拉伸的时候会变形
                                // layero.find("iframe").height(layero.height()-layero.find(".layui-layer-title").height());
                            }
                        });
                        var device = layui.device();//获取设备信息
                        // 如果是手机浏览器，则最大化
                        if(device.android||device.ios||device.weixin) layerTips.full(top_index);//弹出即最大化

                        // 监听表单提交
                        form.on('submit('+_config.open.edit.submit+')', function(data){
                            // console.log(data.elem); //被执行事件的元素DOM对象，一般为button对象
                            // console.log(data.form); //被执行提交的form对象，一般在存在form标签时才会返回
                            // console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}

                            if(zTree){
                                var auth_rule_ids=[];
                                var checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
                                $.each(checked_ids, function (index, item) {
                                    auth_rule_ids.push(item.id);
                                });
                                data.field["rules"]=auth_rule_ids.toString(); // 数组转字符串
                                checked_ids=null;
                                auth_rule_ids=null;
                            }

                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"post",
                                url:_config.open.edit.url,
                                data:data.field,
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: true, // 异步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    layerTips.msg(result.msg,{time: 2000});
                                    if(result.code==1){
                                        top_index && layerTips.close(top_index); //关闭弹出层
                                        //同步更新缓存对应的值
                                        obj.update(data.field);
                                    }
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
                        break;
                    case 'add_pid':
                        if(_config.open.type === 1){
                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"get",
                                url:_config.open.add.url,
                                data:{id:data.id},
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: false, // 同步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    if(result.code==1){
                                        _config.open.add.content = laytpl($(_config.open.add.tpl).html()).render(result);
                                    }else{
                                        layerTips.msg(result.msg,{time: 2000});
                                        return false;
                                    }
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
                        }else if(_config.open.type ===2){
                            _config.open.add.content = _config.open.add.url+"?pid="+data.id;
                        }else {
                            _config.open.add.content = "";
                        }
                        var top_index = layerTips.open({
                            type: _config.open.type,//0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            title: _config.open.add.title,
                            maxmin: _config.open.maxmin, //最大最小化
                            shade: _config.open.shade, //遮罩
                            id : _config.open.id, //用于控制弹层唯一标识
                            area : _config.open.area,//宽高
                            btnAlign: _config.open.btnAlign, // 按钮排列
                            btn: _config.open.add.btn,
                            content: _config.open.add.content,
                            yes: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    // var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                                    // console.log(body.html()); //得到iframe页的body内容
                                    var form_field = body.find('form[lay-filter='+_config.open.add.filter+']').serializeArray();
                                    var field={};
                                    if(form_field){
                                        $.each(form_field,function (i,v){
                                            field[v.name]=v.value;
                                        })
                                    }
                                    if(zTree){
                                        var auth_rule_ids=[];
                                        var checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
                                        $.each(checked_ids, function (index, item) {
                                            auth_rule_ids.push(item.id);
                                        });
                                        field["rules"]=auth_rule_ids.toString(); // 数组转字符串
                                        checked_ids=null;
                                        auth_rule_ids=null;
                                    }
                                    var ind_load=layerTips.load(2);
                                    $.ajax({
                                        type:"post",
                                        url:_config.open.add.url,
                                        data:field,
                                        timeout : 5000, //超时时间设置，单位毫秒
                                        dataType:"json",
                                        async: true, // 异步加载
                                        beforeSend:function(){

                                        },success:function(result){
                                            layerTips.close(ind_load);
                                            layerTips.msg(result.msg,{time: 2000});
                                            if(result.code==1){
                                                top_index && layerTips.close(top_index); //关闭弹出层
                                                tableIns.reload(); // 重新加载
                                            }
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
                                }else{
                                    $('form[lay-filter='+_config.open.add.filter+']').find('button[lay-submit]').click();
                                }
                                // layerTips.close(index);
                                return false;
                            },
                            btn2: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    body.find('form[lay-filter='+_config.open.add.filter+']').find('button[type="reset"]').click();
                                }else{
                                    $('form[lay-filter='+_config.open.add.filter+']').find('button[type="reset"]').click();
                                }
                                return false;
                            },
                            success: function() {
                                form.render(null,_config.open.add.filter);
                                var body = layerTips.getChildFrame('body', top_index);
                                if(_config.zTree.datas){
                                    zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, _config.zTree.datas);
                                }else{
                                    $.post(_config.zTree.url,{"group_id":data.id},function (data) {
                                        zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, data);
                                    });
                                }
                            },
                            cancel:function (index, layero) {
                                layerTips.confirm('若数据未保存，关闭后数据会丢失，确定要关闭吗？',function(ind){
                                    layerTips.close(ind);
                                    layerTips.close(index);
                                });
                                return false;
                            },
                            resizing:function(layero){ //拉伸时修改高度
                                // 提交按钮在 iframe层 里面时，必须加这一句，要不然拉伸的时候会变形
                                // layero.find("iframe").height(layero.height()-layero.find(".layui-layer-title").height());
                            }
                        });
                        var device = layui.device();//获取设备信息
                        // 如果是手机浏览器，则最大化
                        if(device.android||device.ios||device.weixin) layerTips.full(top_index);//弹出即最大化

                        // 监听表单提交
                        form.on('submit('+_config.open.add.submit+')', function(data){
                            // console.log(data.elem); //被执行事件的元素DOM对象，一般为button对象
                            // console.log(data.form); //被执行提交的form对象，一般在存在form标签时才会返回
                            // console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}

                            if(zTree){
                                var auth_rule_ids=[];
                                var checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
                                $.each(checked_ids, function (index, item) {
                                    auth_rule_ids.push(item.id);
                                });
                                data.field["rules"]=auth_rule_ids.toString(); // 数组转字符串
                                checked_ids=null;
                                auth_rule_ids=null;
                            }

                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"post",
                                url:_config.open.add.url,
                                data:data.field,
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: true, // 异步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    layerTips.msg(result.msg,{time: 2000});
                                    if(result.code==1){
                                        top_index && layerTips.close(top_index); //关闭弹出层
                                        //同步更新缓存对应的值
                                        obj.update(data.field);
                                    }
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
                        break;
                }
            });

            // 监听排序切换
            table.on('sort('+_config.table.filter+')', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                // console.log(obj.field); //当前排序的字段名
                // console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
                // console.log(this); //当前排序的 th 对象

                //尽管我们的 table 自带排序功能，但并没有请求服务端。
                //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：

                //重加载
                tableIns.reload({
                    initSort: obj, //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
                    where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                        field: obj.field, //排序字段
                        order: obj.type //排序方式
                    }
                });
            });

            // 监听单元格编辑
            table.on('edit('+_config.table.filter+')', function(obj){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
                // console.log(obj.value); //得到修改后的值
                // console.log(obj.field); //当前编辑的字段名
                // console.log(obj.data); //所在行的所有相关数据

                var ind_load=layerTips.load(2);
                $.ajax({
                    type:"post",
                    url:_config.open.edit.url,
                    data:obj.data,
                    timeout : 5000, //超时时间设置，单位毫秒
                    dataType:"json",
                    async: true, // 异步加载
                    beforeSend:function(){

                    },success:function(result){
                        layerTips.close(ind_load);
                        layerTips.msg(result.msg,{time: 2000});
                        if(result.code!=1){
                            tableIns.reload(); // 如果修改失败则刷新列表
                        }
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

            });

            // 搜索
            form.render(null, 'kit-search-form');
            $('#kit-search-more').on('click', function() {
                $('.kit-search-mored').toggle();
            });

            // 监听开关状态切换
            form.on('switch(switch_status)', function(data){
                // console.log(data.elem); //得到checkbox原始DOM对象
                // console.log(data.elem.checked); //开关是否开启，true或者false
                // console.log(data.value); //开关value值，也可以通过data.elem.value得到
                // console.log(data.othis); //得到美化后的DOM对象
                var id = $(this).data("id");
                var status = data.elem.checked ? 1:2;

                var ind_load=layerTips.load(2);
                $.ajax({
                    type:"post",
                    url:_config.table.url_switch,
                    data:{id:id,status:status},
                    timeout : 5000, //超时时间设置，单位毫秒
                    dataType:"json",
                    async: true, // 异步加载
                    beforeSend:function(){

                    },success:function(result){
                        layerTips.close(ind_load);
                        layerTips.msg(result.msg,{time: 2000});
                        if(result.code!=1){
                            tableIns.reload(); // 如果修改失败则刷新列表
                        }
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

            });

            $('.kit-search-btns').children('a').off('click').on('click', function() {
                var $that = $(this),
                    action = $that.data('action');
                switch (action) {
                    case 'add':
                        if(_config.open.type === 1){
                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"get",
                                url:_config.open.add.url,
                                data:{},
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: false, // 同步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    if(result.code==1){
                                        _config.open.add.content = laytpl($(_config.open.add.tpl).html()).render(result);
                                    }else{
                                        layerTips.msg(result.msg,{time: 2000});
                                        return false;
                                    }
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
                        }else if(_config.open.type ===2){
                            _config.open.add.content = _config.open.add.url;
                        }else {
                            _config.open.add.content = "";
                        }
                        var top_index = layerTips.open({
                            type: _config.open.type,//0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            title: _config.open.add.title,
                            maxmin: _config.open.maxmin, //最大最小化
                            shade: _config.open.shade, //遮罩
                            id : _config.open.id, //用于控制弹层唯一标识
                            area : _config.open.area,//宽高
                            btnAlign: _config.open.btnAlign, // 按钮排列
                            btn: _config.open.add.btn,
                            content: _config.open.add.content,
                            yes: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    // var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                                    // console.log(body.html()); //得到iframe页的body内容
                                    var form_field = body.find('form[lay-filter='+_config.open.add.filter+']').serializeArray();
                                    var field={};
                                    if(form_field){
                                        $.each(form_field,function (i,v){
                                            field[v.name]=v.value;
                                        })
                                    }
                                    if(zTree){
                                        var auth_rule_ids=[];
                                        var checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox
                                        $.each(checked_ids, function (index, item) {
                                            auth_rule_ids.push(item.id);
                                        });
                                        field["rules"]=auth_rule_ids.toString(); // 数组转字符串
                                        checked_ids=null;
                                        auth_rule_ids=null;
                                    }
                                    var ind_load=layerTips.load(2);
                                    $.ajax({
                                        type:"post",
                                        url:_config.open.add.url,
                                        data:field,
                                        timeout : 5000, //超时时间设置，单位毫秒
                                        dataType:"json",
                                        async: true, // 异步加载
                                        beforeSend:function(){

                                        },success:function(result){
                                            layerTips.close(ind_load);
                                            layerTips.msg(result.msg,{time: 2000});
                                            if(result.code==1){
                                                top_index && layerTips.close(top_index); //关闭弹出层
                                                tableIns.reload(); // 重新加载
                                            }
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
                                }else{
                                    $('form[lay-filter='+_config.open.add.filter+']').find('button[lay-submit]').click();
                                }
                                // layerTips.close(index);
                                return false;
                            },
                            btn2: function(index, layero) {
                                if(_config.open.type ===2){
                                    var body = layerTips.getChildFrame('body', index);
                                    body.find('form[lay-filter='+_config.open.add.filter+']').find('button[type="reset"]').click();
                                }else{
                                    $('form[lay-filter='+_config.open.add.filter+']').find('button[type="reset"]').click();
                                }
                                return false;
                            },
                            success: function() {
                                form.render(null,_config.open.add.filter);
                                var body = layerTips.getChildFrame('body', top_index);
                                if(_config.zTree.datas){
                                    zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, _config.zTree.datas);
                                }else{
                                    $.post(_config.zTree.url,{},function (data) {
                                        zTree = $.fn.zTree.init(body.find(_config.zTree.elem), _config.zTree, data);
                                    });
                                }
                            },
                            cancel:function (index, layero) {
                                layerTips.confirm('若数据未保存，关闭后数据会丢失，确定要关闭吗？',function(ind){
                                    layerTips.close(ind);
                                    layerTips.close(index);
                                });
                                return false;
                            },
                            resizing:function(layero){ //拉伸时修改高度
                                // 提交按钮在 iframe层 里面时，必须加这一句，要不然拉伸的时候会变形
                                // layero.find("iframe").height(layero.height()-layero.find(".layui-layer-title").height());
                            }
                        });
                        var device = layui.device();//获取设备信息
                        // 如果是手机浏览器，则最大化
                        if(device.android||device.ios||device.weixin) layerTips.full(top_index);//弹出即最大化

                        // 监听表单提交监听
                        form.on('submit('+_config.open.add.submit+')', function(data){
                            // console.log(data.elem); //被执行事件的元素DOM对象，一般为button对象
                            // console.log(data.form); //被执行提交的form对象，一般在存在form标签时才会返回
                            // console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}

                            var ind_load=layerTips.load(2);
                            $.ajax({
                                type:"post",
                                url:_config.open.add.url,
                                data:data.field,
                                timeout : 5000, //超时时间设置，单位毫秒
                                dataType:"json",
                                async: true, // 异步加载
                                beforeSend:function(){

                                },success:function(result){
                                    layerTips.close(ind_load);
                                    layerTips.msg(result.msg,{time: 2000});
                                    if(result.code==1){
                                        top_index && layerTips.close(top_index); //关闭弹出层
                                        tableIns.reload(); // 重新加载
                                    }
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
                        break;
                    case 'del-bulk':
                        var d = table.checkStatus(_config.table.filter);
                        if (d.data.length === 0) {
                            layerTips.msg('请选择要删除的数据');
                            return;
                        }
                        layerTips.msg('防止误删，暂不提供该操作！！！');
                        // var data = d.data,
                        //     names = [],
                        //     ids = [];
                        // layui.each(data, function(index, item) {
                        //     console.log(item);
                        //     names.push(item.username);
                        //     ids.push(item.id);
                        // });
                        // layerTips.msg(names.join(','));
                        // console.log(ids.join(','));
                        break;
                }
            });

            //自定义验证规则
            form.verify(_config.form_verify);

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
    exports('mytree', mytree);
});
