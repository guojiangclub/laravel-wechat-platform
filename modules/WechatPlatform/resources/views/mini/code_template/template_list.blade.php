<div class="tabs-container">
    <ul class="nav nav-tabs">

        <li>
            <a href="{{route('admin.mini.template.lists',['type'=>1])}}">草稿箱<span
                        class="badge">{{count($draft_list)}}</span></a>
        </li>
        <li class="active">
            <a data-toggle="tab" href="#tab-1" aria-expanded="true">模板库 <span
                        class="badge">{{count($template_list)}}</span></a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                *最多可添加50个，还可添加{{(50-count($template_list))}}个
                <br>
                <br>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>版本号</th>
                        <th style="width:400px;">描述</th>
                        <th>来源小程序appid</th>
                        <th>来源小程序</th>
                        <th>上传开发者</th>
                        <th>最近提交时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($template_list)>0)
                        @foreach ($template_list as $item)
                            <tr>
                                <td>{{$item['template_id']}}</td>
                                <td>
                                    {{$item['user_version']}}
                                    {{--@if(isset($system_mini_master_template['template_id']) AND $system_mini_master_template['template_id']==$item['template_id'])--}}
                                    {{--<span class="label label-danger">master版本</span>--}}
                                    {{--@endif--}}

                                    {{--@if(isset($system_mini_dev_template['template_id']) AND $system_mini_dev_template['template_id']==$item['template_id'])--}}
                                    {{--<span class="label label-danger">dev版本</span>--}}
                                    {{--@endif--}}


                                </td>
                                <td>{{$item['user_desc']}}</td>
                                <td>{{$item['source_miniprogram_appid']}}</td>
                                <td>{{$item['source_miniprogram']}}</td>
                                <td>{{$item['developer']}}</td>
                                <td>{{date('Y-m-d H:i:s',$item['create_time'])}}</td>

                                <td>

                                    {{--<a class="btn btn-xs btn-info add"--}}

                                    {{--data-type="dev"--}}

                                    {{--data-href="{{route('admin.mini.template.settingsTemplate',--}}

                                    {{--[--}}
                                    {{--'template_id'=>$item['template_id'],--}}
                                    {{--'user_version'=>$item['user_version'],--}}
                                    {{--'user_desc'=>$item['user_desc'],--}}
                                    {{--'source_miniprogram_appid'=>$item['source_miniprogram_appid'],--}}
                                    {{--'source_miniprogram'=>$item['source_miniprogram'],--}}
                                    {{--'developer'=>$item['developer'],--}}
                                    {{--'create_time'=>date('Y-m-d H:i:s',$item['create_time']),--}}
                                    {{--'type'=>'dev'--}}

                                    {{--])}}">--}}
                                    {{--<i data-toggle="tooltip" data-placement="top"--}}
                                    {{--class="fa"--}}
                                    {{--title="设置成dev版本">dev</i></a>--}}


                                    {{--<a class="btn btn-xs btn-info add"--}}

                                    {{--data-type="master"--}}

                                    {{--data-href="{{route('admin.mini.template.settingsTemplate',--}}

                                    {{--[--}}
                                    {{--'template_id'=>$item['template_id'],--}}
                                    {{--'user_version'=>$item['user_version'],--}}
                                    {{--'user_desc'=>$item['user_desc'],--}}
                                    {{--'source_miniprogram_appid'=>$item['source_miniprogram_appid'],--}}
                                    {{--'source_miniprogram'=>$item['source_miniprogram'],--}}
                                    {{--'developer'=>$item['developer'],--}}
                                    {{--'create_time'=>date('Y-m-d H:i:s',$item['create_time']),--}}
                                    {{--'type'=>'master'--}}

                                    {{--])}}">--}}
                                    {{--<i data-toggle="tooltip" data-placement="top"--}}
                                    {{--class="fa"--}}
                                    {{--title="设置成master版本">master</i></a>--}}



                                    {{--<a class="btn btn-xs btn-info add"--}}

                                    {{--data-type="test"--}}

                                    {{--data-href="{{route('admin.mini.template.settingsTemplate',--}}

                                    {{--[--}}
                                    {{--'template_id'=>$item['template_id'],--}}
                                    {{--'user_version'=>$item['user_version'],--}}
                                    {{--'user_desc'=>$item['user_desc'],--}}
                                    {{--'source_miniprogram_appid'=>$item['source_miniprogram_appid'],--}}
                                    {{--'source_miniprogram'=>$item['source_miniprogram'],--}}
                                    {{--'developer'=>$item['developer'],--}}
                                    {{--'create_time'=>date('Y-m-d H:i:s',$item['create_time']),--}}
                                    {{--'type'=>'test'--}}

                                    {{--])}}">--}}
                                    {{--<i data-toggle="tooltip" data-placement="top"--}}
                                    {{--class="fa"--}}
                                    {{--title="设置成test版本">test</i></a>--}}



                                    @if(isset($system_mini_template['template_id']) AND isset($system_mini_dev_template['template_id']))

                                        @if($system_mini_template['template_id']!=$item['template_id']
                                        AND  $system_mini_dev_template['template_id']!=$item['template_id']
                                           AND $system_mini_test_template['template_id']!=$item['template_id'])

                                            <a class="btn btn-xs btn-danger delete"
                                               data-href="{{route('admin.mini.template.delete',['id'=>$item['template_id']])}}">
                                                <i data-toggle="tooltip" data-placement="top"
                                                   class="fa fa-trash"
                                                   title="删除"></i></a>
                                        @endif

                                    @else

                                        <a class="btn btn-xs btn-danger delete"
                                           data-href="{{route('admin.mini.template.delete',['id'=>$item['template_id']])}}">
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-trash"
                                               title="删除"></i></a>

                                    @endif


                                    <a class="btn btn-xs btn-info plus" onclick="custom({{$item['template_id']}})"
                                       data-href="">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-image"
                                           title="选择主题"></i></a>


                                </td>

                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>


<div class="template_select" style="display: none;"><select id="template_select"
                                                            style="height: 35px;width: 250px;">
        <option value=0  data-theme_id=0>请选主题分组</option>
        @if(count($theme_list)>0)
            @foreach($theme_list as $item)
                <option value="{{$item->id}}"
                        data-theme_id="{{$item->id}}"
                >{{$item->name}}
                </option>

            @endforeach
        @endif
    </select></div>

<script>
    $('.delete').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要删除该小程序模板吗?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {
            $.post(postUrl, body, function (result) {
                if (result.status) {
                    swal({
                        title: "删除成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '';
                    });
                } else {
                    swal({
                        title: "删除失败",
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });
</script>


<script>
    $('.add').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var type = that.data('type');
        var body = {
            _token: _token
        };
        swal({
            title: "确定设置为当前系统" + type + "版本么?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {
            $.post(postUrl, body, function (result) {
                if (result.status) {
                    swal({
                        title: "设置成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '';
                    });
                } else {
                    swal({
                        title: "设置失败",
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });
</script>


<script>

    var theme_id_old=0;

    function custom(template_id) {

        var api="{{route('admin.mini.theme.api')}}"+'?template_id='+template_id;

        theme_id_old=0;

        $.get(api,function (res) {
            if(res.status){
                theme_id_old=res.data;
                htmlAdd(theme_id_old,template_id);
            }
        })

    }

    function htmlAdd(theme_id_old,template_id) {

        var html = $('.template_select').html();

        swal({
                title: "请选择主题组",
                text: html,
                html: true,
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
            },
            function () {

                // var val = $('.showSweetAlert #template_select').find("option:selected").val();
                // if (val == 0) {
                //     toastr.error("请选择主题组");
                //     return;
                // }

                var theme_id = $('.showSweetAlert #template_select').find("option:selected").data('theme_id');

                var data = {
                    'template_id': template_id,
                    'theme_id': theme_id,
                    '_token':_token
                }

                var url="{{route('admin.mini.theme.operateThemeTemplate')}}"

                $.post(url, data, function (result) {
                    if (result.status) {
                        swal({
                            title: "设置成功！",
                            text: "",
                            type: "success"
                        }, function () {
                            location = '';
                        });
                    } else {
                        swal({
                            title: "设置失败",
                            text: result.message,
                            type: "error"
                        });
                    }
                });

            });

        $('body .sweet-alert #template_select').val(theme_id_old);



    }


</script>





