<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li
                class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">{{$name}}列表</a></li>

        @if(request('client_id'))
            <a class="btn btn-w-m btn-info pull-right" target="_blank"

               @if(request('type')==1)
               href="{{route('web.platform.auth',['client_id'=>request('client_id')])}}"
               @elseif(request('type')==2)
               href="{{route('web.platform.mini.auth',['client_id'=>request('client_id')])}}"
                    @endif

            >添加{{$name}}</a>
        @endif

    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <div class="row" style="margin-bottom:20px;">

                    <form action="{{route('admin.wechat.list')}}" method="get">

                        <div class="col-sm-5">
                            <select class="form-control" name="client_id">
                                <option value="">请选择客户</option>
                                @foreach($customers as $item)
                                    <option value="{{$item->id}}"
                                            @if($item->id==request('client_id')) selected @endif
                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="type" value="{{request('type')}}">

                        <div class="col-sm-3">
                            <div class="input-group search_text col-sm-12">
                                <input type="text" name="appid" placeholder="appid"
                                       value="{{!empty(request('appid'))?request('appid'):''}}" class="form-control">

                            </div>
                        </div>

                        <div class="col-sm-2">
                            <input class="btn btn-info" type="submit" value="查询"/>
                        </div>


                    </form>

                </div>


                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>appid</th>
                        @if($name=='小程序')
                            <th>key</th>
                        @endif
                        <th>客户ID</th>
                        <th>{{$name}}名称</th>
                        <th>原始ID</th>
                        <th>主体名称</th>
                        <th>二维码</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($lists->count()>0)
                        @foreach ($lists as $item)
                            <tr>
                                <td>{{$item->appid}}</td>

                                @if($name=='小程序')
                                    <td>{{md5($item->appid)}}</td>
                                @endif

                                <td>{{$item->client_id}}</td>
                                <td>{{$item->nick_name}}</td>
                                <td>{{$item->user_name}}</td>
                                <td>{{$item->principal_name}}</td>
                                <td>
                                    <a href="{{$item->qrcode_url}}">查看</a>
                                </td>

                                <td>{{$item->created_at}}</td>
                                <td>

                                    @if(request('type')==2)
                                        <a class="btn btn-xs btn-info" target="_blank"
                                           href="{{route('admin.mini.tester.lists',['appid'=>$item->appid])}}">
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-user"
                                               title="体验微信"></i></a>

                                        {{--<a class="btn btn-xs btn-info"--}}
                                        {{--href="{{route('admin.mini.send.index',['appid'=>$item->appid,'type'=>'dev'])}}" target="_blank" >--}}
                                        {{--<span data-toggle="tooltip" data-placement="top"--}}
                                        {{--title="发布小程序dev版本">dev</span></a>--}}

                                        {{--<a class="btn btn-xs btn-info"--}}
                                        {{--href="{{route('admin.mini.send.index',['appid'=>$item->appid,'type'=> 'master'])}}" target="_blank" >--}}
                                        {{--<span data-toggle="tooltip" data-placement="top"--}}
                                        {{--title="发布小程序master版本">master</span></a>--}}


                                        <a class="btn btn-xs btn-info custom"
                                           onclick='custom("{{$item->appid}}","{{md5($item->appid)}}")'
                                           data-href="{{route('admin.mini.send.index',['appid'=>$item->appid,'type'=> 'custom','key'=>md5($item->appid)])}}"
                                           target="_blank">
                                            <i data-toggle="tooltip" data-placement="top" class="fa fa-send"
                                               title="发布小程序自定义版本"></i></a>

                                        <a class="btn btn-xs btn-info"
                                           href="{{route('admin.mini.code.log',['appid'=>$item->appid])}}"
                                           target="_blank">
                                            <i data-toggle="tooltip" data-placement="top" class="fa fa-eye"
                                               title="发布记录"></i></a>

                                    @endif

                                    <a class="btn btn-xs btn-danger delete-wechat"
                                       data-href="{{route('admin.wechat.delete',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>


                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

                <tfoot>
                <tr>
                    <td colspan="6" class="footable-visible">
                        {!!$lists->appends(['client_id'=>request('client_id'),'limit'=>request('limit'),'type'=>$type,'appid'=>request('appid')])->render()!!}
                    </td>
                </tr>
                </tfoot>

                <div class="clearfix"></div>


                <div class="template_select" style="display: none;"><select id="template_select"
                                                                            style="height: 35px;width: 250px;">
                        <option value=-1>请选择模板</option>
                        @if(count($template_list)>0)
                            @foreach($template_list as $item)
                                <option value="{{$item['template_id']}}"
                                        data-template_id="{{$item['template_id']}}"
                                >模板ID:{{$item['template_id']}}
                                    &nbsp&nbsp&nbsp&nbsp&nbsp版本号:{{$item['user_version']}}</option>

                            @endforeach
                        @endif
                    </select></div>
            </div>
        </div>

    </div>
</div>

<script>
    $('.delete-wechat').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要删除吗?",
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
                        location = '{{route('admin.wechat.list',['type'=>$type])}}';
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


    function custom(appid,key) {

        var html = $('.template_select').html();
        swal({
                title: "请选择模板",
                text: html,
                html: true,
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
            },
            function () {

                var val = $('.showSweetAlert #template_select').find("option:selected").val();
                if (val == -1) {
                    toastr.error("请选择模板");
                    return;
                }

                var template_id = $('.showSweetAlert #template_select').find("option:selected").data('template_id');

                var data = {
                    'appid': appid,
                    'template_id': template_id,
                }

                var url = "{{route('admin.mini.send.index')}}" + '?appid=' + appid + '&template_id=' + template_id+'&key='+key;

                window.location.href = url;
            });
    }


</script>



