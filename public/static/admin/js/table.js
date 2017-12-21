layui.use(['table'], function() {
    var table = layui.table,
        $ = layui.jquery,
        layer = layui.layer,
        layerTips = parent.layer === undefined ? layui.layer : parent.layer, //获取父窗口的layer对象
        form = layui.form,
        laytpl = layui.laytpl;
    var tableIns = table.render({
        elem: '#demo',
        height: 'full-135', //容器高度
        url: 'http://py.thinkphp5.com/data/table.html',
        page: true,
        id: 'demo',
        cols: [
            [{
                checkbox: true,
                fixed: true
            }, {
                field: 'id',
                title: 'ID',
                width: 80
            }, {
                field: 'username',
                title: '用户名',
                width: 80
            }, {
                field: 'sex',
                title: '性别',
                width: 80
            }, {
                field: 'city',
                title: '城市',
                width: 80
            }, {
                field: 'sign',
                title: '签名',
                width: 177
            }, {
                field: 'experience',
                title: '积分',
                width: 80
            }, {
                field: 'score',
                title: '评分',
                width: 80
            }, {
                field: 'classify',
                title: '职业',
                width: 80
            }, {
                field: 'wealth',
                title: '财富',
                width: 135,
                sort: true
            }, {
                fixed: 'right',
                title: '操作',
                width: 150,
                align: 'center',
                toolbar: '#barDemo'
            }]
        ],
        done: function(res, curr, count) {
            //如果是异步请求数据方式，res即为你接口返回的信息。
            //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
            // console.log(res);
            // //得到当前页码
            // console.log(curr);
            // //得到数据总量
            // console.log(count);
        },
        loading: true,
        //method: 'post'
    });
    var staticData = {
        citys: [{
            id: 0,
            name: '北京'
        }, {
            id: 1,
            name: '广州'
        }, {
            id: 2,
            name: '深圳'
        }, {
            id: 3,
            name: '杭州'
        }],
        classifies: [{
            id: 0,
            name: '词人'
        }, {
            id: 1,
            name: '诗人'
        }, {
            id: 2,
            name: '作家'
        }, {
            id: 3,
            name: '酱油'
        }]
    };
    //监听搜索表单提交
    form.on('submit(search)', function(data) {
        console.log(data.field);
        layerTips.msg(JSON.stringify(data.field));
        //带条件查询
        tableIns.reload({
            where: data.field
        });
        return false;
    });
    //监听工具条
    table.on('tool(demo)', function(obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值
        var tr = obj.tr; //获得当前行 tr 的DOM对象

        if (layEvent === 'detail') { //查看
            console.log(table.checkStatus('demo'));
            //do somehing
        } else if (layEvent === 'del') { //删除
            layerTips.confirm('真的删除行么', function(index) {
                obj.del(); //删除对应行（tr）的DOM结构
                layerTips.close(index);
                //向服务端发送删除指令
            });
        } else if (layEvent === 'edit') { //编辑
            var d = {
                user: data,
                citys: staticData.citys,
                classifies: staticData.classifies
            };
            //do something
            laytpl($('#edit-tpl').html()).render(d, function(html) {
                layerTips.open({
                    type: 1,
                    title: '表单',
                    content: html,
                    area: ['800px', '600px'],
                    btn: ['提交', '重置', '取消'],
                    yes: function(index, layero) {
                        editIndex = index;
                        $('form[lay-filter="form-edit"]').find('button[lay-submit]').click();
                    },
                    btn2: function(index, layero) {
                        $('form[lay-filter="form-edit"]').find('button[type="reset"]').click();
                        return false;
                    },
                    success: function() {
                        form.render(null, 'form-edit');
                    }
                });
            });
            //同步更新缓存对应的值
            // obj.update({
            //     username: '123',
            //     title: 'xxx'
            // });
        }
    });
    form.render(null, 'kit-search-form');
    $('#kit-search-more').on('click', function() {
        $('.kit-search-mored').toggle();
    });
    var editIndex;
    form.on('submit(formEdit)', function(data) {
        layerTips.msg('formEdit');
        editIndex && layerTips.close(editIndex); //关闭弹出层
        return false;
    });
    $('.kit-search-btns').children('a').off('click').on('click', function() {
        var $that = $(this),
            action = $that.data('action');
        switch (action) {
            case 'add':
                var d = {
                    user: {
                        sign: '',
                        city: '',
                        classify: '',
                        experience: '',
                        id: 0,
                        logins: '',
                        score: '',
                        sex: 1,
                        sign: '',
                        username: '',
                        wealth: ''
                    },
                    citys: staticData.citys,
                    classifies: staticData.classifies
                };
                //渲染
                laytpl($('#edit-tpl').html()).render(d,
                    function(html) {
                        layerTips.open({
                            type: 1,
                            title: '表单',
                            content: html,
                            area: ['800px', '600px'],
                            btn: ['提交', '重置', '取消'],
                            yes: function(index, layero) {
                                editIndex = index;
                                $('form[lay-filter="form-edit"]').find('button[lay-submit]').click();
                            },
                            btn2: function(index, layero) {
                                $('form[lay-filter="form-edit"]').find('button[type="reset"]').click();
                                return false;
                            },
                            success: function() {
                                form.render(null, 'form-edit');
                            }
                        });
                    });
                break;
            case 'del-bulk':
                var d = table.checkStatus('demo');
                if (d.data.length === 0) {
                    layerTips.msg('请选择要删除的数据');
                    return;
                }
                var data = d.data,
                    names = [],
                    ids = [];
                layui.each(data, function(index, item) {
                    console.log(item);
                    names.push(item.username);
                    ids.push(item.id);
                });
                layerTips.msg(names.join(','));
                console.log(ids.join(','));
                break;
        }
    });
});