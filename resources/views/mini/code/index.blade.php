<div class="col-md-12">
    <style>
        .colorpicker-visible{
            z-index: 9999999;
        }
        .title {
            font-size: 40px;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            display: block;
            text-align: center;
            margin: 20px 0 10px 0px;
        }

        .links {
            /*text-align: center;*/
            margin-bottom: 20px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>

    <div class="title">
        {{$appid}}
    </div>
    <div class="links">

    </div>
</div>


<div class="row">


    <div class="col-md-4">

        <div class="box box-default">

            <div class="box-header with-border">


                @if($status_message)

                    <h3 class="box-title">{{$status_message}}</h3>

                @endif


                @if(request('type') AND !$status_message)
                    <h3 class="box-title">选择{{request('type')}}版本</h3>
                @endif


                @if(request('template_id') AND !$status_message)

                    <h3 class="box-title">选择自定义版本</h3>
                @endif

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>

                        <tr>
                            <td>体验二维码</td>
                            <td>
                                <img width="150" height="150"
                                     src="{{route('admin.mini.code.getQrCode',['appid'=>request('appid')])}}" alt="">
                            </td>
                        </tr>

                        @if(isset($audit->status) AND $audit->status==2)
                            <tr>
                                <td>状态</td>
                                <td>
                                    待审核
                                    <br>
                                    (撤回上限每天一次每个月10次)
                                    <a class="label label-info pull-right" onclick="withdrawAudit();">撤回审核 </a>
                                </td>
                            </tr>
                        @endif

                        @if(isset($audit->status) AND $audit->status==0)
                            <tr>
                                <td>状态</td>
                                <td>
                                    审核成功
                                    <br>
                                    <a class="label label-success pull-right" onclick="release()">发布上线</a>
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td width="120px">ID</td>
                            <td>{{$system_mini_template['template_id']}}</td>
                        </tr>

                        <tr>
                            <td width="120px">服务类目</td>
                            <td class="category_txt">
                                @if(count($category)>0)@foreach($category as $item)@foreach($item as $citem) @if(!is_numeric($citem)){{$citem}}@endif @endforeach @endforeach @endif
                            </td>
                        </tr>

                        <tr>
                            <td width="120px">版本号</td>
                            <td><span class="label label-info">{{$system_mini_template['user_version']}}</span></td>
                        </tr>
                        <tr>
                            <td width="120px">描述</td>
                            <td>{{$system_mini_template['user_desc']}}</td>
                        </tr>
                        <tr>
                            <td width="120px">模板添加时间</td>

                            @if(is_numeric($system_mini_template['create_time']))
                                <td>{{date('Y-m-d H:s:i',$system_mini_template['create_time'])}}</td>
                            @else
                                <td>{{$system_mini_template['create_time']}}</td>
                            @endif

                        </tr>

                        @if(isset($audit->note) AND $audit->note)
                            <tr>
                                <td>备注</td>
                                <td>
                                    {{$audit->note}}
                                </td>
                            </tr>
                        @endif

                        @if(isset($audit->auditid) AND $audit->auditid)
                            <tr>
                                <td>提交审核时间</td>
                                <td>
                                    {{$audit->audit_time}}
                                </td>
                            </tr>
                        @endif


                        @if(isset($audit->theme) AND !empty($audit->theme))

                            <?php  $audit_theme=json_decode($audit->theme,true)?>
                            <tr>
                                <td>主题</td>
                                <td>
                                   <span>{{isset($audit_theme['title'])?$audit_theme['title']:''}}</span>
                                    <br>
                                    @if(isset($audit_theme['img']))
                                      <img width="80"  height="120" src="{{$audit_theme['img']}}" alt="">
                                    @endif
                                </td>
                            </tr>

                         @else
                            <tr id="theme-no" style="display: none">
                                <td>主题</td>
                                <td>
                                    <span></span>
                                    <br>
                                    <img id="theme-no-img" style="display: none" width="80"  height="120" src="" alt="">
                                </td>
                            </tr>
                        @endif


                        @if(!$status_message)
                           <tr>
                               <td>修改小程序代码</td>
                               <td>
                                   <a class="label label-info" id="users-btn" data-toggle="modal"
                                      data-target="#modal" data-backdrop="static" data-keyboard="false"
                                      data-url="{{route('admin.mini.code.model',['template_id'=>request('template_id')])}}">
                                       自定义
                                   </a>
                               </td>
                           </tr>
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modal" class="modal inmodal fade"></div>

        </div>

    </div>


    {{--中间--}}
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-right: 10px;">体验者微信</h3>
                <a onclick="tester_create()" class="label label-info">添加</a>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        @if(count($testers)>0)
                            @foreach($testers as $item)
                                <tr>
                                    <td width="240px">{{$item->wechatid}}</td>

                                    <td>
                                        <a class="btn btn-xs btn-danger tester-delete"
                                           data-href="{{route('admin.mini.tester.delete',['id'=>$item->wechatid,'appid'=>request('appid')])}}">
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-trash"
                                               title="删除"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        @endif


                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    {{--右边--}}

    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-right: 10px;">操作</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr class="CommitMiniCodeUpload">
                            <td width="240px">小程序代码上传</td>

                            <td>
                                        <span class="pull-right installed CommitMiniCodeUpload_success"
                                              style="display: none">

                                            <i class="fa fa-check"></i>
                                        </span>
                                <span class="pull-right installed CommitMiniCodeUpload_error" style="display: none">

                                            <i class="fa fa-times"></i>
                                        </span>
                            </td>

                        </tr>

                        <tr class="CommitMiniCodeExamine" style="display: none">
                            <td width="240px">提交小程序审核</td>

                            <td>

                                <a onclick="CommitMiniCodeExamine(CommitMiniCodeExamine_url,CommitMiniCodeExamine_data)"
                                   class="label label-info pull-right CommitMiniCodeExamine_a">提交审核</a>

                                <span class="pull-right installed CommitMiniCodeExamine_success" style="display: none">

                                            <i class="fa fa-check"></i>
                                        </span>
                                <span class="pull-right installed CommitMiniCodeExamine_error" style="display: none">

                                            <i class="fa fa-times"></i>
                                        </span>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</div>

<script src="https://cdn.bootcss.com/Sortable/1.6.0/Sortable.min.js"></script>

@include('wechat-platform::mini.code.script')

<script>

    @if(isset($audit->status) AND $audit->status==1)
    window.setTimeout(go, 100);

    function go() {
        swal({
                title: "存在上线发布失败记录",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "查看",
                cancelButtonText: '重新提交审核',
                closeOnConfirm: false
            },
            function () {
                location.href = '{{route('admin.mini.code.log',['appid'=>$appid,'auditid'=>$audit->auditid])}}'

            });
    }

    @endif


    //提交小程序代码
    var CommitMiniCode_url = "{{route('admin.mini.code.commit',['appid'=>request('appid')])}}";
    var CommitMiniCode_data = {
        _token: _token,
        'ext_json': {
            'extAppid': "{{request('appid')}}"
        },
        'template_id': "{{$system_mini_template['template_id']}}",
        'user_version': "{{$system_mini_template['user_version']}}",
        'user_desc': "{{$system_mini_template['user_desc']}}",
    };

    @if(isset($audit->status))
    @if ($audit->status==2 ||$audit->status==0)
    $('.CommitMiniCodeUpload_success').show()
    $('.CommitMiniCodeExamine').show()
    $('.CommitMiniCodeExamine_a').hide();
    $('.CommitMiniCodeExamine_success').show()
    @endif
    @endif

    CommitMiniCode(CommitMiniCode_url, CommitMiniCode_data)

    function CommitMiniCode(url, data) {

        $.post(url, data, function (result) {

            if (result.status) {

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

    //提交审核

    var CommitMiniCodeExamine_url = "{{route('admin.mini.code.submitAudit',['appid'=>request('appid')])}}"

    var category_txt = $('.category_txt').text();

    var CommitMiniCodeExamine_data_ext_json=CommitMiniCode_data.ext_json;

    var CommitMiniCodeExamine_data = {
        _token: _token,
        'item_list': {
            "address": "{{$page}}",
            "tag": "商城",
            "title": "首页",
        },
        'log': {
            'appid': "{{request('appid')}}",
            'template': {
                'template_id': "{{$system_mini_template['template_id']}}",
                'user_version': "{{$system_mini_template['user_version']}}",
                'user_desc': "{{$system_mini_template['user_desc']}}",
                'create_time': "{{$system_mini_template['create_time']}}",
                'category': category_txt,
                'address': "{{$page}}"
            },
            'theme':'',
            'ext_json':CommitMiniCodeExamine_data_ext_json
        }
    }


    @if(isset($category[0]))

            @foreach($category[0] as $k=>$citem)

        CommitMiniCodeExamine_data['item_list']["{{$k}}"] = "{{$citem}}"

    @endforeach

    @endif


    function CommitMiniCodeExamine(url, data) {

        swal({

                title: "确定要提交审核么?",
                text: "",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: '取消',
                closeOnConfirm: false,
                type: "input",
                animation: "slide-from-top",
                inputPlaceholder: "备注"
            },
            function (inputValue) {
                if (!inputValue) {
                    swal.showInputError("填写备注");
                    return false
                }
                data.log.note = inputValue;

                $.post(url, data, function (result) {

                    if (result.status) {

                        swal({
                            title: "提交审核成功",
                            text: "",
                            type: "success",
                            confirmButtonText: "确定"
                        }, function () {
                            location.href = "";

                        });

                    } else {
                        swal({
                            title: "提交审核失败",
                            text: result.message,
                            type: "error"
                        });

                    }
                });

            });


    }


    function withdrawAudit() {

        swal({
            title: "确定要撤回审核么?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {

            var url = "{{route('admin.mini.code.withdrawAudit',['appid'=>request('appid')])}}";

            var data = {
                _token: _token,
            }

            $.post(url, data, function (result) {

                if (result.status) {

                    swal({
                        title: "撤回审核成功",
                        text: "",
                        type: "success",
                        confirmButtonText: "确定"
                    }, function () {
                        location.href = "{{route('admin.wechat.list',['type'=>2])}}";

                    });

                } else {
                    swal({
                        title: "撤回审核失败",
                        text: result.message,
                        type: "error"
                    });

                }
            });

        });

    }


    //上线发布
    function release() {
        swal({
            title: "确定要上线发布么?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {

            var url = "{{route('admin.mini.code.release',['appid'=>request('appid')])}}";

            var data = {
                _token: _token,
            }

            $.post(url, data, function (result) {

                if (result.status) {

                    swal({
                        title: "上线发布成功",
                        text: "",
                        type: "success",
                        confirmButtonText: "确定"
                    }, function () {
                        location.href = "{{route('admin.mini.code.log',['appid'=>request('appid')])}}";

                    });

                } else {
                    swal({
                        title: "上线发布失败",
                        text: result.message,
                        type: "error"
                    });

                }
            });

        });
    }


</script>


