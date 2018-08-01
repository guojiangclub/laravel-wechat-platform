<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li
                class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">公众号列表</a></li>

    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <div class="row" style="margin-bottom:20px;">

                    <form action="{{route('admin.customers.wechat.list')}}" method="get">

                        <div class="col-sm-6">
                            <select class="form-control" name="client_id">
                                <option value="">请选择客户</option>
                                @foreach($customers as $item)
                                    <option value="{{$item->id}}"
                                            @if($item->id==request('client_id')) selected @endif
                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input class="btn btn-info" type="submit" value="查询"/>
                        </div>
                    </form>

                </div>


                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>appid</th>
                        <th>client_id</th>
                        <th>nick_name</th>
                        <th>user_name</th>
                        <th>principal_name</th>
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
                                <td>{{$item->client_id}}</td>
                                <td>{{$item->nick_name}}</td>
                                <td>{{$item->user_name}}</td>
                                <td>{{$item->principal_name}}</td>

                                <td>
                                    <a href="{{$item->qrcode_url}}">查看</a>
                                </td>

                                <td>{{$item->created_at}}</td>
                                <td>

                                    <a class="btn btn-xs btn-danger delete-wechat"
                                       data-href="{{route('admin.customers.wechat.delete',['id'=>$item->id])}}">
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
                        {!!$lists->appends(['client_id'=>request('client_id'),'limit'=>request('limit')])->render()!!}
                    </td>
                </tr>
                </tfoot>

                <div class="clearfix"></div>
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
                        location = '{{route('admin.customers.wechat.list')}}';
                    });
                } else {
                    swal({
                        title: result.message,
                        text: "",
                        type: "warning"
                    });
                }
            });
        });
    });
</script>

