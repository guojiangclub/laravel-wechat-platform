@extends('wechat-platform::mini.layouts.bootstrap_modal')

@section('modal_class')
    modal-lg
@stop
@section('title')
    自定义小程序
@stop

@section('after-styles-end')

@stop


<script>
    var theme = {};
    theme[0] = {
        'img': '',
        'param': ''
    };

    var bars = {};
    bars[0] = {
        'param': ''
    };
</script>

@section('body')
    <div class="app">

        <div class="box-body">
            <table class="table-responsive">
                <table class="table table-striped">
                    <tbody>

                    <tr>
                        <td class="col-sm-4" style="text-align: center;
vertical-align: middle!important;">
                            配色主题
                        </td>
                        <td class="col-sm-6" style="text-align: center;
vertical-align: middle!important;">
                            <select name="" id="select_box" class="form-control">

                                <option id="them_0" value=0>请选择配色主题</option>

                                {{--<option value=-1>自定义</option>--}}
                                @if(isset($theme->theme->items) AND count($theme->theme->items)>0)
                                    @foreach($theme->theme->items as $k=> $item)
                                        <script>

                                            theme["{{$item->id}}"] = {
                                                'id': "{{$item->id}}",
                                                'title': "{{$item->title}}",
                                                'theme_id': "{{$item->theme_id}}",
                                                'img': "{{$item->img}}",
                                                'param': "{{$item->param}}"
                                            }
                                        </script>

                                        <option value="{{$item->id}}" data-img="{{$item->img}}"

                                                @if($item->is_default) selected @endif

                                        >{{$item->title}}</option>


                                        @if($item->is_default)
                                            <script>
                                                img("{{$item->img}}", "{{$item->id}}")
                                                CommitMiniCodeExamine_data.log.theme = theme["{{$item->id}}"];
                                                CommitMiniCode_data.ext_json.ext.appid="{{md5(request('appid'))}}";
                                                $('#theme-no').show();
                                                $('#theme-no span').text(theme["{{$item->id}}"]['title']);
                                                $('#theme-no-img').show();
                                                $('#theme-no-img').attr('src', theme["{{$item->id}}"]['img']);
                                            </script> @endif

                                    @endforeach
                                @endif
                            </select>
                        </td>
                        <td class="col-sm-2">
                            <img class="pull-right" id="img_theme" src="" width="150" height="180" alt="">
                        </td>
                    </tr>



                    <tr class="custom">
                        <td class="col-sm-4" style="text-align: center;
vertical-align: middle!important;">
                            导航栏背景颜色
                        </td>
                        <td class="col-sm-6">
                            <div class="input-group colorpicker-component color" data-color="#FFFFFF"
                                 title="Using data-color attribute in the colorpicker element">
                                <input type="text" id="navigationBarBackgroundColor" class="form-control color_input"
                                       name="navigationBarBackgroundColor" value="#FFFFFF"/>
                                <span class="input-group-addon color-box"><i></i></span>
                            </div>
                        </td>

                    </tr>


                    <tr class="custom">
                        <td class="col-sm-4" style="text-align: center;
vertical-align: middle!important;">
                            导航栏标题颜色
                        </td>
                        <td class="col-sm-6">
                            <select name="navigationBarTextStyle" id="navigationBarTextStyle" class="form-control">
                                <option value="black" selected>黑色</option>
                                <option value="white">白色</option>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td class="col-sm-4" style="text-align: center;
vertical-align: middle!important;">
                            菜单主题
                        </td>
                        <td class="col-sm-6" style="text-align: center;
vertical-align: middle!important;">
                            <select name="" id="select_bars_box" class="form-control">

                                <option id="them_bars_0" value=0>请选择菜单主题</option>
                                @if(isset($theme->theme->bars) AND count($theme->theme->bars)>0)

                                    @foreach($theme->theme->bars as $k=> $item)

                                        <script>
                                            bars["{{$item->id}}"] = {
                                                'id': "{{$item->id}}",
                                                'title': "{{$item->title}}",
                                                'theme_id': "{{$item->theme_id}}",
                                                'param': "{{$item->param}}"
                                            }
                                        </script>

                                        <option value="{{$item->id}}"

                                                @if($item->is_default) selected @endif

                                        >{{$item->title}}</option>


                                        @if($item->is_default)
                                            <script>
                                                bars("{{$item->id}}")
                                                CommitMiniCodeExamine_data.log.bars = bars["{{$item->id}}"];
                                            </script> @endif
                                    @endforeach

                                @endif

                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td class="bar">注意：菜单至少2个，可拖拽排序，可修改文案</td>
                        <td>
                            <ul id="bar">

                            </ul>
                        </td>
                    </tr>

                    <tr id="quanzi" style="display: none">
                        <td class="bar" style="text-align: center;">是否显示圈子</td>
                        <td>
                            <input type="radio"  class="quan_yes" name="quan" value="1" onclick="quanzi(1)">是
                        </td>
                        <td>
                            <input type="radio"  class="quan_no"  style="margin-left: -350px;" name="quan" onclick="quanzi(0)" value="0" checked>否
                        </td>
                    </tr>


                    </tbody>
                </table>
            </table>
            <button style="position: absolute;bottom:-50px;right:20px" data-dismiss="modal"
                    class="btn btn-primary pull-right" onclick="Submission()">确定
            </button>

        </div>
    </div>
@stop


@section('footer')

    <button type="button" class="btn btn-link" data-dismiss="modal" style="margin-right: 80px;">取消</button>

@stop

<script src="https://cdn.bootcss.com/Sortable/1.6.0/Sortable.min.js"></script>

<script>
    custom_hide();
    $('#select_box').change(function (e) {
        var val = $(this).val();
        if (val >0) {
            var img = theme[val]['img'];
            var param = theme[val]['param'].replace(/&quot;/g, '"');
            theme[val]['param'] = param
            $('#img_theme').attr('src', img);
            CommitMiniCode_data.ext_json.ext = JSON.parse(param);
            CommitMiniCode_data.ext_json.ext.appid="{{md5(request('appid'))}}";
            CommitMiniCodeExamine_data.log.theme = theme[val];
            $('#theme-no').show();
            $('#theme-no span').text(theme[val]['title']);
            $('#theme-no-img').show();
            $('#theme-no-img').attr('src', theme[val]['img']);
            custom_hide();

        } else if(val==0){
            $('#theme-no').hide();
            $('#theme-no span').text('');
            $('#theme-no-img').hide();
            $('#theme-no-img').attr('src', '');
            //新代码
            $('#img_theme').attr('src', '');
            //
            CommitMiniCodeExamine_data.log.theme = "";
            delete CommitMiniCode_data.ext_json.ext;
            custom_hide();
        }else if(val==-1){
            custom_show();
            $('#theme-no').hide();
            $('#theme-no span').text('');
            $('#theme-no-img').hide();
            $('#theme-no-img').attr('src', '');
            CommitMiniCodeExamine_data.log.theme = "";
            delete CommitMiniCode_data.ext_json.ext;
        }

    })


    function custom_show(){
        $('.custom').show();
        $('#navigationBarTextStyle').val('black');
        $('.color').data('#ffffff');
        $('#navigationBarBackgroundColor').val('#ffffff');
        $('.color-box i').attr('style','background-color:rgb(255, 255, 255)')
    }

    function custom_hide(){
        $('.custom').hide();
    }

    $('#select_bars_box').change(function (e) {
        var val = $(this).val();
        if (val != 0) {
            $('.bar').show();
            var param = bars[val]['param'].replace(/&quot;/g, '"');
            bars[val]['param'] = param
            CommitMiniCode_data.ext_json.tabBar = JSON.parse(param);
            CommitMiniCodeExamine_data.log.bars = bars[val];
            bars(val);
            $('#quanzi').show();
            //$('.quan_yes').iCheck('check');
            //$('.quan_no').iCheck('uncheck');

        } else {
            $('#bar').empty();
            $('.bar').hide();
            CommitMiniCodeExamine_data.log.bars = "";
            delete CommitMiniCode_data.ext_json.tabBar;
            $('#quanzi').hide();
            $('.quan_yes').iCheck('uncheck');
            $('.quan_no').iCheck('check');
        }
    })


    function quanzi(value){
        console.log(value);
        var val={
            "pagePath": "pages/travels/index/index",
            "text": "圈子",
            "iconPath": "assets/image/travels.png",
            "selectedIconPath": "assets/image/travels-r.png"
        }

        var li = ["<li id='quan_li' style=\"list-style: none\"  >",
            "    <input type=\"text\"" +
            "data-input=" +
            JSON.stringify(val).replace(/"/g, "'") +
            " " +
            "class=\"form-control\" " +
            "value=" + val.text +" " +
            "placeholder="+"菜单原名："+ val.text +
            ">",
            "</li>"].join("");

        if(!$('#quan_li').length){
            $('#bar').append(li);return;
        }

        if($('#quan_li').length && value==0){
            $('#quan_li input').val('');
            $('#quan_li').hide();
            return;
        }
        $('#quan_li').show();
        $('#quan_li input').val('圈子');
    }

    $('.color').colorpicker();

    function img(img, id) {
        var param = theme[id]['param'].replace(/&quot;/g, '"');
        theme[id]['param'] = param
        CommitMiniCode_data.ext_json.ext =JSON.parse(param);
        $('#img_theme').attr('src', img);
    }

    function bars(id) {
        var param = bars[id]['param'].replace(/&quot;/g, '"');
        bars[id]['param'] = param

        CommitMiniCode_data.ext_json.tabBar = param;

        var param = JSON.parse(param);

        $.each(param.list, function (key, val) {

            var li = ["<li style=\"list-style: none\">",
                "    <input type=\"text\"" +
                "data-input=" +
                JSON.stringify(val).replace(/"/g, "'") +
                " " +
                "class=\"form-control\" " +
                "value=" + val.text +
                " " +
                "placeholder="+"菜单原名："+ val.text +
                ">",
                "</li>"].join("");

            $('#bar').append(li);
        })

    }


    function Submission() {
        var val=$('#select_box').val();

        if(val==0){
            swal({
                title: "请选择配色主题",
                text:'',
                type: "error"
            });
            return
        }

        // if(val==-1){
        //     CommitMiniCode_data.ext_json.window = {};
        //     CommitMiniCode_data.ext_json.window.navigationBarBackgroundColor = $('#navigationBarBackgroundColor').val();
        //     CommitMiniCode_data.ext_json.window.navigationBarTextStyle = $('#navigationBarTextStyle').val();
        // }else{
        //     delete  CommitMiniCode_data.ext_json.window;
        // }

        CommitMiniCode_data.ext_json.window = {};

        if('navigationBarBackgroundColor' in CommitMiniCode_data.ext_json.ext){
            CommitMiniCode_data.ext_json.window.navigationBarBackgroundColor = CommitMiniCode_data.ext_json.ext.navigationBarBackgroundColor;
        }

        if('navigationBarTextStyle' in CommitMiniCode_data.ext_json.ext){
            CommitMiniCode_data.ext_json.window.navigationBarTextStyle = CommitMiniCode_data.ext_json.ext.navigationBarTextStyle;
        }

        if(!'navigationBarTextStyle' in CommitMiniCode_data.ext_json.ext &&'navigationBarBackgroundColor' in CommitMiniCode_data.ext_json.ext){
            delete  CommitMiniCode_data.ext_json.window;
        }

        if(CommitMiniCode_data.ext_json.tabBar){

            var bar = JSON.parse(CommitMiniCode_data.ext_json.tabBar);

            bar.list = getList();

            if(bar.list.length<2){
                swal({
                    title: "小程序菜单至少2个",
                    text:'',
                    type: "error"
                });
                return
            }

            if(bar.list.length>5){
                swal({
                    title: "小程序菜单最多5个",
                    text:'',
                    type: "error"
                });
                return
            }

            CommitMiniCode_data.ext_json.tabBar = bar
        }

        console.log(CommitMiniCode_data);

        $.post(CommitMiniCode_url, CommitMiniCode_data, function (result) {

            if (result.status) {

                swal({
                    title: "修改成功",
                    text: "",
                    type: "success"
                });

                $('.CommitMiniCodeUpload_success').show()
                $('.CommitMiniCodeExamine').show()
            } else {
                swal({
                    title: "上传小程序代码失败",
                    text: result.message,
                    type: "error"
                });
                $('.CommitMiniCodeUpload_error').show()
            }
        });
    }

</script>

<script>
    (function () {
        'use strict';

        var byId = function (id) {
                return document.getElementById(id);
            },

            loadScripts = function (desc, callback) {
                var deps = [], key, idx = 0;

                for (key in desc) {
                    deps.push(key);
                }

                (function _next() {
                    var pid,
                        name = deps[idx],
                        script = document.createElement('script');

                    script.type = 'text/javascript';
                    script.src = desc[deps[idx]];

                    pid = setInterval(function () {
                        if (window[name]) {
                            clearTimeout(pid);

                            deps[idx++] = window[name];

                            if (deps[idx]) {
                                _next();
                            } else {
                                callback.apply(null, deps);
                            }
                        }
                    }, 30);

                    document.getElementsByTagName('head')[0].appendChild(script);
                })()
            },

            console = window.console;

        if (!console.log) {
            console.log = function () {
                alert([].join.apply(arguments, ' '));
            };
        }

        Sortable.create(byId('bar'), {
            group: "words",
            animation: 150,
            onAdd: function (evt) {
                console.log('onAdd.bar:', evt.item);
            },
            onUpdate: function (evt) {
                console.log('onUpdate.bar:', evt.item);
            },
            onRemove: function (evt) {
                console.log('onRemove.bar:', evt.item);
            },
            onStart: function (evt) {
                console.log('onStart.foo:', evt.item);
            },
            onEnd: function (evt) {
                console.log('onEnd.foo:', evt.item);
            }
        });

    })();

    //getli
    function getList() {
        var list = [];
        var obj = $('body #bar li')
        $.each(obj.find('input'), function (k, input) {
            var val = $(input).val();
            if (val != '') {
                var input = $(input).data('input');

                var input = JSON.parse(input.replace(/'/g, '"'))

                input.text = val;

                list.push(input);
            }
        })

        return list;
    }


</script>










