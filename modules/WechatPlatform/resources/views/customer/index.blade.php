<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 客户列表</a></li>
        <a onclick="create()" class="btn btn-w-m btn-info pull-right">添加客户</a>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">

                <div class="row" style="margin-bottom:20px;">

                    <form action="{{route('admin.customers.list')}}" method="get">

                        <div class="col-sm-4">
                            <div class="input-group search_text col-sm-12">
                                <input type="text" name="name" placeholder="name"
                                       value="{{!empty(request('name'))?request('name'):''}}" class="form-control">

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
                        <th>ID</th>
                        <th>name</th>
                        <th>serect</th>
                        <th>时间</th>
                        <th>公众号</th>
                        <th>小程序</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($customers->count()>0)
                        @foreach ($customers as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td id="foo{{$item->id}}">
                                    {{$item->secret}}
                                    <a class="btn btn-xs btn-info pull-right" data-clipboard-action="copy"
                                       data-clipboard-target="#foo{{$item->id}}">复制</a>
                                </td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <a no-pjax href="{{route('admin.wechat.list',['client_id'=>$item->id,'type'=>1])}}">查看</a>
                                    <span class="badge">
                                        {{$item->wechat->count()}}
                                    </span>
                                </td>
                                <td>
                                    <a no-pjax href="{{route('admin.wechat.list',['client_id'=>$item->id,'type'=>2])}}">查看</a>
                                    <span class="badge"> {{$item->mini->count()}}</span>
                                </td>
                                <td>
                                    @if($item->id>2)
                                        <a class="btn btn-xs btn-danger delete-customer"
                                           data-href="{{route('admin.customers.delete',['id'=>$item->id])}}">
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-trash"
                                               title="删除"></i></a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

                <tfoot>
                <tr>
                    <td colspan="6" class="footable-visible">
                        {!!$customers->appends(['limit'=>request('limit')])->render() !!}
                    </td>
                </tr>
                </tfoot>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>

<script src="//cdn.bootcss.com/clipboard.js/1.6.1/clipboard.min.js"></script>

<script>
    var clipboard = new Clipboard('.btn');

    clipboard.on('success', function (e) {
        swal("复制成功", "", "success")
    });

    clipboard.on('error', function (e) {

    });
</script>

<script>
    $('.delete-customer').on('click', function () {
        var that = $(this);
        var postUrl = that.data('href');
        var body = {
            _token: _token
        };
        swal({
            title: "确定要删除吗？",
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
                        location = '{{route('admin.customers.list')}}';
                    });
                } else {
                    swal({
                        title: '删除失败',
                        text: result.message,
                        type: "error"
                    });
                }
            });
        });
    });


    function create() {
        swal({
                title: "添加客户",
                text: "",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "保存",
                cancelButtonText: "取消",
                animation: "slide-from-top",
                inputPlaceholder: "请输入客户name"
            },
            function (inputValue) {
                if (!inputValue) {
                    swal.showInputError("请输入客户name");
                    return false
                }
                var url = "{{route('admin.customers.store',['_token'=>csrf_token()])}}";
                var data = {'name': inputValue}
                $.post(url, data, function (ret) {

                    if (!ret.status) {
                        swal("创建失败!", ret.message, "warning");
                    } else {
                        swal({
                            title: "创建成功",
                            text: "",
                            type: "success",
                            confirmButtonText: "确定"
                        }, function () {
                            location.href = "{{route('admin.customers.list')}}";

                        });
                    }
                });

            });
    }


</script>

